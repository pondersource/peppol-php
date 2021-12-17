# Overview of changes/remarks of alignment

The following list give a general overview of the changes made to the specifications as part of the alignment with the EN 16931 invoice. This list does not address the additional RFC that were approved and adopted.

## Business terms

- Qualified reference elements added to Order.

- Removed type and date from contract references

- All addresses changed to include 3 lines instead of two.

- Added address information for tax representatives, where appropriate.

- Use of business terms aligned across BIS specifications.

- Use of label elements aligned between Order agreement and Punch Out.

- Contact information aligned across BIS.

## VAT

- Exchange rates for VAT currencies removed.

- VAT calculation aligned with EN calculation model.

- Structure of VAT information aligned with EN VAT structure.

## Code and identifiers

- Customization and profile identifiers made mandatory in all BIS.

- Party and item identifiers restricted to ICD code list.

- Aligning use of code lists, examples are the allowance/charge lists and VAT category codes.

- Assigning fixed code lists and removing requirements for code attributes.

- Action code lists aligned between BIS’s.

## Rules and validations

- Rule mandating either sellers or standard item Id added to all except Order.

- Internal calculation of allowances and charges aligned.

- Added validations to prevent use of empty elements.

- Automated unit testing adopted for all BIS using code snippets instead of full files.

- Rules separated into Basic rule and Business rules. Basic rules auto generated.

- Various redundant rules removed.

## UBL syntax bindings

- Alignment of syntax bindings.

- Party name remapped to party legal name.

- "Your reference" remapped to Customer reference from Buyer/Contact/Id

## Documentation

- All documentation moved to AsciiDoc or XML form and maintained as code in GitHub.

- BIS specifications moved from Word to browsable website.

- Data model and syntax bindings moved from BIS document to browsable data model.

- Code lists for all BIS maintained jointly and hyperlinked where used.

- Traceability of changes improved by linking between Jira issues and GitHub updates.

- Validation on elements values and calculations aligned with EN.

- Allowance and charge classes aligned in terms of use of percentage, reason code and VAT.

