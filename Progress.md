# Goal

The goal is a clear design with easily modifiable code. Each method/class must have a few functions as possible.

Thinking for 7 packages with the use of object-oriented python

# packages
sender - receiver - SAP - RAP - invoice - SMP - SML

SAP(Sender Acces Point)

RAP(Receiver Acces Point)

SMP(Service Metadata Publisher )

SML(Service Metadata Locator)

Based : https://peppol.eu/what-is-peppol/peppol-transport-infrastructure/

Invoice must implement as abstract to make its fields obvious. For now, we will handle the ubl as a simple object(not an XML file. So we don't need the XML library for this step). 

The Soap methods will be added probably at input- output packages.

# General requirements 

Sender and receiver must both have an account at peppol(certified companies)

# conclusions 

Use of Django( python web framework )

# TODO

Implement our application in a local network.

Handle the invoice just like a pdf file 










