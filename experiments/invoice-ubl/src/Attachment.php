<?php

use Exception;
use InvalidArgumentException;

class Attachment {
    private $filePath;

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
     * the validate function when xml will be serialize
     * missing file path and attachment does not exist
     */
    public function validate() {
        if ($this->filePath === null) {
            throw new InvalidArgumentException('Missing filePath');
        }

        if (file_exists($this->filePath) === false) {
            throw new InvalidArgumentException('Attachment at filePath does not exist');
        }
    }
}