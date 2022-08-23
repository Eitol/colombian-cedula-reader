from abc import ABC, abstractmethod
from dataclasses import dataclass
from typing import Optional

from dbr import BarcodeReader, EnumErrorCode, EnumBarcodeFormat, EnumBarcodeComplementMode, EnumDeblurMode, \
    EnumLocalizationMode, EnumScaleUpMode


class AbstractBarcodeReader(ABC):
    @abstractmethod
    def read(self, data: bytes) -> bytes:
        pass


@dataclass()
class DynamSoftBarcodeReaderOpts:
    license_key: str
    barcode_type: int
    barcode_min_len: Optional[int]


class DynamSoftBarcodeReader(AbstractBarcodeReader):
    def __init__(self, opts: DynamSoftBarcodeReaderOpts):
        if not opts.license_key:
            raise ValueError('license_key is required')
        err = BarcodeReader.init_license(opts.license_key)
        if err[0] != EnumErrorCode.DBR_OK:
            raise ValueError("License error: " + err[1])
        self.opts = opts
        self.reader = BarcodeReader()
        if opts.barcode_type == EnumBarcodeFormat.BF_PDF417:
            self.config_accuracy_first_pdf417()
        elif opts.barcode_type == EnumBarcodeFormat.BF_QR_CODE:
            self.config_accuracy_first_qr()
    
    def config_accuracy_first_pdf417(self):
        # Obtain current runtime settings of instance.
        sts = self.reader.get_runtime_settings()
        # 1. Set expected barcode format
        # The more precise the barcode format is set, the higher the accuracy.
        # Mostly, misreading only occurs on reading oneD barcode. So here we use OneD barcode format to demonstrate.
        sts.barcode_format_ids = self.opts.barcode_type
        sts.barcode_format_ids_2 = EnumBarcodeFormat.BF_NULL
        sts.minResultConfidence = 80
        sts.max_algorithm_thread_count = 1
        sts.scale_down_threshold = 10000
        sts.expected_barcodes_count = 1
        if self.opts.barcode_min_len is not None:
            sts.minBarcodeTextLength = self.opts.barcode_min_len
        # Apply the new settings to the instance
        self.reader.update_runtime_settings(sts)

    def config_accuracy_first_qr(self):
        sts = self.reader.get_runtime_settings()
        sts.barcode_complement_modes = EnumBarcodeComplementMode.BCM_SKIP
        sts.barcode_format_ids = EnumBarcodeFormat.BF_QR_CODE
        sts.deblur_modes = EnumDeblurMode.DM_SHARPENING | EnumDeblurMode.DM_GRAY_EQUALIZATION
        sts.localization_modes = EnumLocalizationMode.LM_CONNECTED_BLOCKS
        sts.scale_up_modes = EnumScaleUpMode.SUM_LINEAR_INTERPOLATION
        sts.max_algorithm_thread_count = 1
        sts.scale_down_threshold = 10000
        sts.expected_barcodes_count = 1
        sts.localization_modes = EnumLocalizationMode.LM_CONNECTED_BLOCKS
        sts.scale_up_modes = EnumScaleUpMode.SUM_LINEAR_INTERPOLATION
        sts.max_algorithm_thread_count = 1
        sts.scale_down_threshold = 10000
        sts.timeout = 5000

        # Apply the new settings to the instance
        self.reader.update_runtime_settings(sts)
    
    def read(self, data: bytes) -> bytes:
        r = self.reader.decode_buffer(data)
        if r is None or len(r) == 0:
            raise ValueError('no barcode found')
        return r[0].barcode_bytes
