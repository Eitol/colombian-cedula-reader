from dataclasses import dataclass

@dataclass()
class Location:
    department: str
    department_code: str
    municipality: str
    municipality_code: str


@dataclass()
class DocumentInfo:
    document_number: str
    afis_code: str
    finger_card: str


@dataclass()
class CardIdData:
    first_name: str
    middle_name: str
    last_name: str
    second_last_name: str
    birth_date: str
    blood_type: str
    gender: str
    location: Location
    document_info: DocumentInfo
# 3f7789e7-5e57-47a2-9347-ba42d305ca48
# Bearer OGUwOTNkMDE2ODY3NDM3M2IxM2Q2NDRhMDc2NDI1NmY6M2Y3Nzg5ZTctNWU1Ny00N2EyLTkzNDctYmE0MmQzMDVjYTQ4