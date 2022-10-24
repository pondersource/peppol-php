<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

/*
    https://docs.peppol.eu/poacc/billing/3.0/codelist/MimeCode/
*/
class MimeCode {    
    const CSV = 'text/csv';
    const PDF = 'application/pdf';
    const PNG = 'image/png';
    const JPEG = 'image/jpeg';
    const OPEN_XML_SPREAD_SHEET = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    const OPEN_XML_DOCUMENT_SHEET = 'application/vnd.oasis.opendocument.spreadsheet';
}