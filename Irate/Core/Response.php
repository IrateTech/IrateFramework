<?php

namespace Irate\Core;

class Response {

  private $contentType = 'html';
  private $contentTypeFormatted = 'text/html';
  private $status = 200;
  private $isAttachment = false;
  private $fileName = 'file';

  /**
   * Sets the response status
   */
  public function setStatus($status = null) {
    if (!is_null($status)) $this->status = $status;

    return $this;
  }

  public function isAttachment ($name) {
    $this->isAttachment = true;
    $this->fileName = $name;
    return $this;
  }

  /**
   * Sets the content type
   */
  public function setContentType($type) {
    switch ($type) {
      case 'json':
        $this->contentType = 'json';
        $this->contentTypeFormatted = 'application/json';
        break;

      case 'plain':
        $this->contentType = 'plain';
        $this->contentTypeFormatted = 'text/plain';
        break;

      case 'csv':
        $this->contentType = 'csv';
        $this->contentTypeFormatted = 'text/csv';
        break;
    }

    return $this;
  }

  /**
   * Outputs data depending on status
   * content type, and data passed.
   */
  public function output($data = null) {

    http_response_code($this->status);

    // Set the content type.
    header('Content-type: ' . $this->contentTypeFormatted);

    if ($this->isAttachment) {
      header("Content-Disposition: attachment; filename=" . $this->fileName);
    }

    // If there is data, and the content type is JSON, output it.
		if (!is_null($data)) {
			if ($this->contentType == 'json') {
				if (is_array($data) || is_object($data)) {
					$data = json_encode($data);
				}
			}
		}

    echo $data;
		exit;
	}
}
