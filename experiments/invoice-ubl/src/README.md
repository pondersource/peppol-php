## UBL Invoice

## UBL Country->Address and Attachment->AdditionalDocument
## UBL Contact and Scheme

<img src="https://github.com/pondersource/peppol-php/blob/main/experiments/invoice-ubl/src/pics/diagram_ubl_start.PNG?raw=true"/>

### Unit Code 
We have more unit code that need fill. I created the class for it. But we can add more unit codes. Feel free create PR.

- [Unit Code](https://docs.peppol.eu/poacc/billing/3.0/codelist/UNECERec20/)

### Invoice Type Code 
A code specifying the functional type of the Invoice. The base value for send invoice is 380. But you can see more code below in link.

- [Invoice Type Code](https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL1001-inv/)

### UBL Party TaxScheme->PartyTaxScheme->Party, LegalEntity->Party, Contact->Party, PostalAddress->Party

<img src="https://github.com/pondersource/peppol-php/blob/main/experiments/invoice-ubl/src/pics/ubl-party.PNG?raw=true"/>