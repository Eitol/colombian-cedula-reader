from typing import Optional

import cv2
from dbr import *

from src.barcode.colombian_pdf417_decoder import ColombianIdCardPdf417Decoder
from src.barcode.barcode_reader import DynamSoftBarcodeReaderOpts, AbstractBarcodeReader, DynamSoftBarcodeReader
from src.barcode.model import CardIdData


class ColombianIdCardQRDecoder:
    def __init__(self, data: bytes):
        self.result = data

    def decode(self) -> Optional[CardIdData]:
        return


def decode_qr_file(image_path: str, license_key: str) -> CardIdData:
    opts = DynamSoftBarcodeReaderOpts(
        license_key=license_key,
        barcode_type=EnumBarcodeFormat.BF_QR_CODE,
        barcode_min_len=None,
    )
    reader: AbstractBarcodeReader = DynamSoftBarcodeReader(opts)
    img_data = cv2.imread(image_path)
    raw_data = reader.read(img_data)
    decoder = ColombianIdCardPdf417Decoder(raw_data)
    return decoder.decode()
