<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

/*
    https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL2005/
*/
class ElectronicAddressScheme {
    const SIRENE = '0002'; // System Information et Repertoire des Entreprise et des Etablissements: SIRENE
    const Swedish = '0007'; // Organisationsnummer (Swedish legal entities)
    const SIRET = '0009'; // SIRET-CODE
    const TUNNUS = '0037'; // LY-tunnus
    const DUNS = '0060'; // Data Universal Numbering System (D-U-N-S Number)
    const EAN = '0088'; // EAN Location Code
    const DANISH_CHAMBER = '0096'; // DANISH CHAMBER OF COMMERCE Scheme (EDIRA compliant)
    const FTI = '0097'; // FTI - Ediforum Italia, (EDIRA compliant)
    const NEDERLAND = '0106'; // "Vereniging van Kamers van Koophandel en Fabrieken in Nederland (Association of Chambers of Commerce and Industry in the Netherlands), Scheme (EDIRA compliant)"
    const EUROPEAN = '0130'; // Directorates of the European Commission
    const SIA = '0135'; // SIA Object Identifiers
    const SECETI = '0142'; // SECETI Object Identifiers
    const STANDARD = '0147'; // Standard Company Code
    const AUSTRALIAN = '0151'; // Australian Business Number (ABN) Scheme
    const TEIKOKU = '0170'; // Teikoku Company Code
    const UIDB = '0183'; // Numéro d'identification suisse des enterprises (IDE), Swiss Unique Business Identification Number (UIDB)
    const DIGSTORG = '0184'; // DIGSTORG
    const SOCIAL_SECURITY = '0188'; // Corporate Number of The Social Security and Tax Number System
    const DUTCH = '0190'; // Dutch Originator's Identification Number
    const JUSTICE = '0191'; // Centre of Registers and Information Systems of the Ministry of Justice
    const ENHETSREGISTERET = '0192'; // Enhetsregisteret ved Bronnoysundregisterne
    const UBL = '0193'; // UBL.BE party identifier
    const SINGAPORE = '0195'; // Singapore UEN identifier
    const ICELAND = '0196'; // Kennitala - Iceland legal id for individuals and legal entities
    const ERSTORG = '0198'; // ERSTORG
    const LEI = '0199'; // Legal Entity Identifier (LEI)
    const LITHUANIA = '0200'; // Legal entity code (Lithuania)
    const IPA = '0201'; // Codice Univoco Unità Organizzativa iPA
    const PEC = '0202'; // Indirizzo di Posta Elettronica Certificata
    const LEITWEG = '0204'; // Leitweg-ID
    const ENTERPRISE = '0208'; // Numero d'entreprise / ondernemingsnummer / Unternehmensnummer
    const GS1 = '0209'; // GS1 identification keys
    const FISCALE = '0210'; // CODICE FISCALE
    const PARTITA_IVA = '0211'; // PARTITA IVA
    const FINNISH_IDENTIFIER = '0212'; // Finnish Organization Identifier
    const FINNISH_TAX = '0213'; // Finnish Organization Value Add Tax Identifier
    const NET = '0215'; // Net service ID
    const OVT = '0216'; // OVTcode
    const DANISH = '9901'; // Danish Ministry of the Interior and Health
    const IVA = '9906'; // Ufficio responsabile gestione partite IVA
    const TAX = '9907'; // TAX Authority
    const HUNGARY = '9910'; // Hungary VAT number
    const BRN = '9913'; // Business Registers Network
    const OSTRICH = '9914'; // Österreichische Umsatzsteuer-Identifikationsnummer
    const OSTRICH2 = '9915'; // "Österreichisches Verwaltungs bzw. Organisationskennzeichen"
    const SWIFT = '9918'; // "SOCIETY FOR WORLDWIDE INTERBANK FINANCIAL, TELECOMMUNICATION S.W.I.F.T"
    const KENNZIFFER = '9919'; // Kennziffer des Unternehmensregisters
    const SPAIN = '9920'; // Agencia Española de Administración Tributaria
    const ANDORRA = '9922'; // Andorra VAT number
    const ALBANIA = '9923'; // Albania VAT number
    const BOSNIA = '9924'; // Bosnia and Herzegovina VAT number
    const BELGIUM = '9925'; // Belgium VAT number
    const BULGARIA = '9926'; // Bulgaria VAT number
    const SWITZERLAND = '9927'; // Switzerland VAT number
    const CYPRUS = '9928'; // Cyprus VAT number
    const CZECH = '9929'; // Czech Republic VAT number
    const GERMANY = '9930'; // Germany VAT number
    const ESTONIA = '9931'; // Estonia VAT number
    const UK = '9932'; // United Kingdom VAT number
    const GREECE = '9933'; // Greece VAT number
    const CROATIA = '9934'; // Croatia VAT number
    const IRELAND = '9935'; // Ireland VAT number
    const LIECHTENSTEIN = '9936'; // Liechtenstein VAT number
    const LITHUANIA_VAT = '9937'; // Lithuania VAT number
    const LUXEMBURG = '9938'; // Luxemburg VAT number
    const LATVIA = '9939'; // Latvia VAT number
    const MONACO = '9940'; // Monaco VAT number
    const MONTENEGRO = '9941'; // Montenegro VAT number
    const MACEDONIA = '9942'; // Macedonia, the former Yugoslav Republic of VAT number
    const MALTA = '9943'; // Malta VAT number
    const NETHERLANDS = '9944'; // Netherlands VAT number
    const POLAND = '9945'; // Poland VAT number
    const PORTUGAL = '9946'; // Portugal VAT number
    const ROMANIA = '9947'; // Romania VAT number
    const SERBIA = '9948'; // Serbia VAT number
    const SLOVENIA = '9949'; // Slovenia VAT number
    const SLOVAKIA = '9950'; // Slovakia VAT number
    const SAN_MARINO = '9951'; // San Marino VAT number
    const TURKEY = '9952'; // Turkey VAT number
    const VATICAN = '9953'; // Holy See (Vatican City State) VAT number
    const SWEDEN = '9955'; // Swedish VAT number
    const FRENCH = '9957'; // French VAT number
}