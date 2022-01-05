import javax.xml.crypto.*;
import javax.xml.crypto.dsig.*;
import javax.xml.crypto.dom.*;
import javax.xml.crypto.dsig.dom.DOMSignContext;
import javax.xml.crypto.dsig.keyinfo.*;
import javax.xml.crypto.dsig.spec.C14NMethodParameterSpec;
import java.io.FileOutputStream;
import java.io.OutputStream;
import java.security.*;
import java.util.Collections;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.transform.*;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import org.w3c.dom.Document;

public class GenDetached {

    //
    // Synopsis: java GenDetached [output]
    //
    // where output is the name of the file that will contain the detached
    // signature. If not specified, standard output is used.
    //
    public static void main(String[] args) throws Exception {

        // First, create a DOM XMLSignatureFactory that will be used to
        // generate the XMLSignature and marshal it to DOM.
        XMLSignatureFactory fac = XMLSignatureFactory.getInstance("DOM");

        // Create a Reference to an external URI that will be digested
        // using the SHA1 digest algorithm
        Reference ref = fac.newReference("http://www.w3.org/TR/xml-stylesheet",             fac.newDigestMethod(DigestMethod.SHA1, null));

        // Create the SignedInfo
        SignedInfo si = fac.newSignedInfo(
            fac.newCanonicalizationMethod
                (CanonicalizationMethod.INCLUSIVE_WITH_COMMENTS,
                 (C14NMethodParameterSpec) null),
            fac.newSignatureMethod(SignatureMethod.DSA_SHA1, null),
            Collections.singletonList(ref));

        // Create a DSA KeyPair
        KeyPairGenerator kpg = KeyPairGenerator.getInstance("DSA");
        kpg.initialize(512);
        KeyPair kp = kpg.generateKeyPair();

        // Create a KeyValue containing the DSA PublicKey that was generated
        KeyInfoFactory kif = fac.getKeyInfoFactory();
        KeyValue kv = kif.newKeyValue(kp.getPublic());

        // Create a KeyInfo and add the KeyValue to it
        KeyInfo ki = kif.newKeyInfo(Collections.singletonList(kv));

        // Create the XMLSignature (but don't sign it yet)
        XMLSignature signature = fac.newXMLSignature(si, ki);

        // Create the Document that will hold the resulting XMLSignature
        DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
        dbf.setNamespaceAware(true); // must be set
        Document doc = dbf.newDocumentBuilder().newDocument();

        // Create a DOMSignContext and set the signing Key to the DSA
        // PrivateKey and specify where the XMLSignature should be inserted
        // in the target document (in this case, the document root)
        DOMSignContext signContext = new DOMSignContext(kp.getPrivate(), doc);

        // Marshal, generate (and sign) the detached XMLSignature. The DOM
        // Document will contain the XML Signature if this method returns
        // successfully.
        signature.sign(signContext);

        // output the resulting document
        OutputStream os;
        if (args.length > 0) {
           os = new FileOutputStream(args[0]);
        } else {
           os = System.out;
        }

        TransformerFactory tf = TransformerFactory.newInstance();
        Transformer trans = tf.newTransformer();
        trans.transform(new DOMSource(doc), new StreamResult(os));
    }
}
