# The Milestones

## 1. Trust User Interface for both sender and receiver 🟢

  ### Network of Trust
  
  * Users can create a Network of Trust 
    - How?  By sending and receiving contact requests
  * Each contact can be:
    - Supplier
    - Costumer
    - Simple contact 

 ### Messages
 
 * Users can exchange messages
 * Each message can be:
   - Invoice
   - Purchase order
   - Simple message
 * Each message includes:
   - Recipient:
       -  Contact
       -  New WebID/ PeppolID address  
   - Subject   : The subject of the message
   - Body      : Simple Text 
   - XML File  :
       -  Invoice 
       -  Purchase order
       -  Null
   - Type      : The type of the XML File
   - Shipping method: 
       - Peppol classic 
       - AS4  
 * Recipient can clearly see the credentials of the sender
   - Self-hosted or gateway-certified
   - Backed by a government's company registry or not
 
  ### Send a new message out the Network of Trust 
  
  #### Invoice
   * The Recipient will be asked if he trust the Sender as a supplier or not
     - ACCEPT : Sender marked as a supplier and added into the Network(respectively for the sender)
     - REJECT : Keep the Sender as 'unkown' 

  #### Purchase Order
   * The Recipient will be asked if he trust the Sender as a costumer or not
     - ACCEPT : Sender marked as a costumer and added into the Network(respectively for the sender)
     - REJECT : Keep the Sender as 'unkown' 
  
  #### Simple Message
  * The Recipient will just receive a new contact request
     - ACCEPT : Sender added into the Network(respectively for the sender)
     - REJECT : Keep the Sender as 'unkown' 
  
  ### UI
  
  * Custom icons exists for each terminology
  * Q&A
  
## 2. Hybrid sender, including: 🟢
  * AS4 client (based on generic SOAP client library)
  * Recipient details discovery (Peppol ID directory lookup)
  * Passing the official AS4 compliance tests for sending
  * Option to send to self-hosted non-Peppol recipient identities

## 3. Hybrid receiver, including:  🟢
  * AS4 server (based on generic SOAP server library)
  * Service Metadata Publisher, to announce the endpoint details for a Peppol ID.
  * Passing the official AS4 compliance tests for receiving
  * Option to receive from self-hosted non-Peppol sender identities
  * Sender identity / signature verification for Peppol ID's and self-hosted ID's

## 4. Re-signing gateway  🟢
  * forwards an invoice from a whitelisted sender, replacing the sender signature with a sending-gateway signature, thus making the invoice Peppol-compliant if the sending gateway's cryptographic key pair is officially certified.
  * Know-Your-Customer implementation, showing ability to check sender identity against two or three different national company registries.
  * re-signs and forwards SMP registrations on behalf of whitelisted receivers.

## 5. Nextcloud integration  🟢 
  * the leading open source self-hostable personal cloud system Nextcloud does not yet support sending and receiving them via Peppol's SOAP-based AS4 protocol.
  * we will package the sender and the receiver modules as a Nextcloud app, directly installable for existing Nextcloud self-hosters from the Nextcloud app store.
  * demo the integration and the full sender-to-receiver flow in a screencast.
