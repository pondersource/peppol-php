<?php

use Exception;
use InvalidArgumentException;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Attachment implements XmlSerializable {
    private $filePath;
    private $externalReference;

    /**
     * Determine mime type
     */
    public function getFileMimeType(): string {
        if (($mime_type = mime_content_type($this->filePath)) !== false) {
            return $mime_type;
        }

        throw new Exception('Could not determine mime_type of '.$this->filePath);
    }

    /**
     * get file path
     */
    public function getFilePath(): ?string {
        return $this->filePath;
    }

    /**
     * Set File Path
     */
    public function setFilePath(?string $filePath): Attachment {
        $this->filepath = $filePath;
    }

    /**
     * get external reference
     * External document location
     */
    public function getExternalReference(): ?string {
        return $this->externalReference;
    }

    /**
     * Set external document location
     */
    public function setExternalReference(?string $externalReference): Attachment {
        $this->externalReference = $externalReference;
        return $this;
    }

    /**
     * the validate function when xml will be serialize
     * missing file path and attachment does not exist
     */
    public function validate() {
        if ($this->filePath === null && $this->externalReference) {
            throw new InvalidArgumentException('Missing filePath and document location');
        }

        if ($this->filePath !== null && file_exists($this->filePath) === false) {
            throw new InvalidArgumentException('Attachment at filePath does not exist');
        }
    }

    /**
     * Serialize Attachment
     */
    public function xmlSerialize(Writer $writer)
    {
        if($this->filePath) {
            $fileContents = base64_encode(file_get_contents($this->filePath));
            $mime_type = $this->getFileMimeType();

            $writer->write([
                'name' => Schema::CBC . 'EmbeddedDocumentBinaryObject',
                'values' => $fileContents,
                'attributes' => [
                    'mimeCode' => $mime_type,
                    'fileName' => $this->filePath
                ]
            ]);
        }
        if ($this->externalReference) {
            $writer->writeElement(
                Schema::CAC . 'ExternalReference',
                [ Schema::CBC . 'URI' => $this->externalReference ]
            );
        }
    }
}