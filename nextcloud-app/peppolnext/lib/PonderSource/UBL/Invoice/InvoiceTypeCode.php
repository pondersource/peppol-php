<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

/*
    https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL1001-inv/
*/
class InvoiceTypeCode {
    const REQUEST_FOR_PAYMENT = 71;
    const DEBIT_NOTE_SERVICE = 80;
    const METERED_SERVICE = 82;
    const DEBIT_NOTE_ADJUSTMENT = 84;
    const TAX_NOTIFICATION = 102;
    const WORK_COMPLETED = 218;
    const UNIT_COMPLETED = 219;
    const COMMERCIAL_WITH_PACKING_LIST = 331;
    const COMMERCIAL = 380;
    const COMMISSION = 382;
    const DEBIT_NOTE = 383;
    const PREPAYMENT = 386;
    const TAX = 388;
    const FACTORED = 393;
    const CONSIGNMENT = 395;
    const FORWARDER_DISCREPANCY_REPORT = 553;
    const INSURER = 575;
    const FORWARDER = 623;
    const FREIGHT = 780;
    const CLAIM_NOTIFICATION = 817;
    const CONSULAR = 870;
    const PARTIAL_CONSTRUCTION = 875;
    const PARTIAL_FINAL_CONSTRUCTION = 876;
    const FINAL_CONSTRUCTION = 877;
}