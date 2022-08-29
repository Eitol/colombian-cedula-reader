"""
Permite leer desde el pdf417 de la cédula colombiada desde una imagen y
arrojar el resultado parseado en consola
"""
import json
from typing import Tuple

from dbr import *

from src.barcode.colombian_pdf417_decoder import decode_file


def print_usage():
    print('Usage: LICENSE_KEY=<license_key> python3 main.py <image_path>')
    print('Example: LICENSE_KEY=blablabla python3 main.py ./id_card.png')


def get_args() -> Tuple[str, str]:
    if len(sys.argv) < 2:
        print('Missing image path')
        print_usage()
        exit(1)
    image_path_ = sys.argv[1]
    # Check if image_path is a valid path
    if not os.path.isfile(image_path_):
        print(f'{image_path_} is not a valid path')
        print_usage()
        exit(1)
    licence_key_ = os.environ['LICENSE_KEY']
    if not licence_key_:
        print('Please provide a license key in the environment variable LICENSE_KEY')
        print_usage()
        exit(1)
    return image_path_, licence_key_


if __name__ == "__main__":
    image_path, licence_key = get_args()
    result: str = ''
    try:
        data = decode_file(image_path, licence_key)
        result = json.dumps(data, indent=2, default=lambda o: o.__dict__)
    except Exception as e:
        result_err = {
            'error': str(e)
        }
        result = json.dumps(result_err, indent=2, default=lambda o: o.__dict__)
    print(result)
