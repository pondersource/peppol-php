<?php

use Exception;

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
}