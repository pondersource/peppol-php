# European Union SMP
## References
Link to Peppol SMP specifications: https://docs.peppol.eu/edelivery/smp/PEPPOL-EDN-Service-Metadata-Publishing-1.2.0-2021-02-24.pdf

Link to European Union's implementation of SMP's documentation: https://ec.europa.eu/digital-building-blocks/wikis/display/DIGITAL/SMP

*In order to fully understand this document, you have to read the SMPLookup document first.*

## API calls
All calls require username password authentication
```
Authorization : Basic base64Encode(username:password)
```

### Define a new participant
PUT SMPHost / url_encode(ParticipantIdentifierScheme::ParticipantIdentifierValue)
``` xml
<?xml version="1.0" encoding="utf-8" ?>
<ServiceGroup xmlns="http://busdox.org/serviceMetadata/publishing/1.0/" xmlns:ids="http://busdox.org/transport/identifiers/1.0/">
	<ids:ParticipantIdentifier scheme="{ParticipantIdentifierScheme}">{ParticipantIdentifierValue}</ids:ParticipantIdentifier>
	<ServiceMetadataReferenceCollection>
	</ServiceMetadataReferenceCollection>
	<Extension>
	</Extension>
</ServiceGroup>
```

### Remove a participant
DELETE SMPHost / url_encode(ParticipantIdentifierScheme::ParticipantIdentifierValue)

### Specify endpoint/certificate for a document type for a participant
PUT SMPEndPoint
``` xml
<?xml version="1.0" encoding="utf-8" ?>
<smp:ServiceMetadata>
	<smp:ServiceInformation>
		<id:ParticipantIdentifier scheme="{ParticipantIdentifierScheme}">{ParticipantIdentifierValue}</id:ParticipantIdentifier>
		<id:DocumentIdentifier scheme="{DocumentTypeScheme}">{DocumentType}</id:DocumentIdentifier>
		<smp:ProcessList>
			<smp:Process>
				<id:ProcessIdentifier scheme="{ProcessIdentifierScheme}">{ProcessIdentifier}</id:ProcessIdentifier>
				<smp:ServiceEndpointList>
					<smp:Endpoint transportProfile="peppol-transport-as4-v2_0">
						<wsa:EndpointReference>
							<wsa:Address>{endpoint url}</wsa:Address>
						</wsa:EndpointReference>
						<smp:RequireBusinessLevelSignature>false</smp:RequireBusinessLevelSignature>
						<smp:Certificate>{certificate}</smp:Certificate>
						<smp:ServiceDescription>{service description}</smp:ServiceDescription>
						<smp:TechnicalContactUrl>{technical contact email}</smp:TechnicalContactUrl>
					</smp:Endpoint>
				</smp:ServiceEndpointList>
			</smp:Process>
		</smp:ProcessList>
	</smp:ServiceInformation>
</smp:ServiceMetadata>
```
*Note that namespace identifiers are excluded in the sample XML. Obviously, it needs to be a valid XML in real life.*

*Note that ServiceMetadata can have a Redirect child instead of a ServiceInformation.*

### Remove endpoint for a document type for a participant
DELETE SMPEndPoint
