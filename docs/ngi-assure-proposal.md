https://nlnet.nl/assure/

# draft...

Ideas:

Phase 1:
Peppol in Python

Phase 2:
Fully automated KYC; do for Peppol what LetsEncrypt did for TLS.

Phase 3:
Peppol in self-hosted Open Source bookkeeping systems
4. Odoo
5. Dolibarr
6. ERPNext


Phase 4:
World Ledger Gossip

>  distributed ledgers and (post) blockchain technologies that create redundant data sets managed independently by mutually distrustful parties

Phase 5:
Integration with Solid
MoneyPane now only has bank statement import. Add: send/receive invoices between Solid users, based on WebID
WebID as an alternative to Peppol ID

Phase 6:
Bookkeeping system can receive Peppol-signed invoice from a legal entity, or server-signed from any Odoo/Dolibarr/ERPNext instance.

Odoo (KYC'ed) -> Corner 2 forwarder -> Peppol network
Peppol network -> Corner 3 forwarder -> Odoo (KYC'ed)
any -> any

Corner 1 should probably always sign with self-signed cert.
Corner 2 will replace with its own signature based on corner 1 KYC
Corner 3 will announce corner 4 if KYC'ed
Corner 3 will check the corner 2 signature but corner 4 could also do that itself.