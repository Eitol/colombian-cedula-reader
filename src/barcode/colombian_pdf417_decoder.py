import re
from typing import Optional

import cv2
from dbr import *

from src.barcode.barcode_reader import DynamSoftBarcodeReaderOpts, DynamSoftBarcodeReader, AbstractBarcodeReader
from src.barcode.localities import LOCALITIES
from src.barcode.model import CardIdData, DocumentInfo, Location

COLOMBIAN_PDF417_DATA_LEN = 530
COLOMBIAN_PDF417_CODING = 'latin-1'


def strip_null(s: str) -> str:
    return s.split('\x00')[0]


class ColombianIdCardPdf417Decoder:
    def __init__(self, data: bytes):
        self.data = data

    def get_field(self, start_byte: int, end_byte: int) -> str:
        return strip_null(self.data[start_byte:end_byte].decode(COLOMBIAN_PDF417_CODING))

    def decode(self) -> Optional[CardIdData]:
        if bytes('PubDSK_', 'ascii') not in self.data:
            return None
        data = re.sub(bytes("(\00){2,}", 'ascii'), bytes("\00", 'ascii'), self.data)
        sp = data.split(bytes("\00", 'ascii'))
        afis_code = sp[0].decode(COLOMBIAN_PDF417_CODING)[2:]
        finger_card = sp[2].decode(COLOMBIAN_PDF417_CODING)[:8]
        if len(sp[2]) > 8:
            doc_number = sp[2].decode(COLOMBIAN_PDF417_CODING)[10:18]
            last_name = sp[2].decode(COLOMBIAN_PDF417_CODING)[18:]
        else:
            sp = sp[1:]
            doc_number = sp[2].decode(COLOMBIAN_PDF417_CODING)[:10]
            last_name = sp[2].decode(COLOMBIAN_PDF417_CODING)[10:]
        second_last_name = sp[3].decode(COLOMBIAN_PDF417_CODING)
        first_name = sp[4].decode(COLOMBIAN_PDF417_CODING)
        middle_name = sp[5].decode(COLOMBIAN_PDF417_CODING)
        if middle_name.endswith("-") or middle_name.endswith("+"):
            middle_name = ''
            sp.insert(5, bytes("x", 'ascii'))
        gender = sp[6].decode(COLOMBIAN_PDF417_CODING)[1]
        anno_nacimiento = sp[6].decode(COLOMBIAN_PDF417_CODING)[2:6]
        mes_nacimiento = sp[6].decode(COLOMBIAN_PDF417_CODING)[6:8]
        dia_nacimiento = sp[6].decode(COLOMBIAN_PDF417_CODING)[8:10]
        codigo_municipio = sp[6].decode(COLOMBIAN_PDF417_CODING)[10:12]
        codigo_departamento = sp[6].decode(COLOMBIAN_PDF417_CODING)[12:15]
        blood_type = sp[6].decode(COLOMBIAN_PDF417_CODING)[16:18]
        nombre_departamento, nombre_municipio = self.extract_departamento(
            codigo_departamento, codigo_municipio
        )
        return CardIdData(
            first_name=first_name,
            middle_name=middle_name,
            last_name=last_name,
            second_last_name=second_last_name,
            birth_date=f'{dia_nacimiento}-{mes_nacimiento}-{anno_nacimiento}',
            blood_type=blood_type,
            gender=gender,
            location=Location(
                department_code=codigo_departamento,
                municipality_code=codigo_municipio,
                department=nombre_departamento,
                municipality=nombre_municipio,
            ),
            document_info=DocumentInfo(
                document_number=doc_number,
                afis_code=afis_code,
                finger_card=finger_card,
            ),
        )

    @staticmethod
    def extract_departamento(codigo_departamento, codigo_municipio):
        nombre_departamento = ''
        nombre_municipio = ''
        for loc_tuple in LOCALITIES:
            if loc_tuple[0] == codigo_municipio and loc_tuple[1] == codigo_departamento:
                nombre_municipio = loc_tuple[2]
                nombre_departamento = loc_tuple[3]
        if nombre_municipio == '':
            nombre_municipio = 'No encontrado'
        if nombre_departamento == '':
            nombre_departamento = 'No encontrado'
        return nombre_departamento, nombre_municipio


def decode_file(image_path: str, license_key: str) -> CardIdData:
    opts = DynamSoftBarcodeReaderOpts(
        license_key=license_key,
        barcode_type=EnumBarcodeFormat.BF_PDF417,
        barcode_min_len=COLOMBIAN_PDF417_DATA_LEN,
    )
    reader: AbstractBarcodeReader = DynamSoftBarcodeReader(opts)
    img_data = cv2.imread(image_path)
    raw_data = reader.read(img_data)
    decoder = ColombianIdCardPdf417Decoder(raw_data)
    return decoder.decode()
