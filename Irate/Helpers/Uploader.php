<?php

namespace Irate\Helpers;

/**
 * Uploader Class
 */
class Uploader
{

  private $file = null;
  private $path = null;

  public $error = false;

  /**
   * Processes the file to be uploaded.
   * @param  array  $options [description]
   * @return boolean
   */
  public function process ($options = []) {
    // Reset the error from any past use.
    $this->error = false;

    if (!$this->isWritable()) return false;

    // Generate a name for the file
    $name = $this->generateFileName(
      (isset($options['name']) ? $options['name'] : false)
    );

    // If name could not be resolved.
    if (!$name) return false;

    // Construct the new path
    $target = $this->constructFilePath($name);

    if (move_uploaded_file($this->file["tmp_name"], $target)) {

      // Reset class vars for future uses.
      $this->file = null;
      $this->path = null;

      return [
        'success' => true,
        'file_name' => $name
      ];
    } else {

      // Reset class vars for future uses.
      $this->file = null;
      $this->path = null;

      $this->setError('Unable to create file.');
      return false;
    }
  }

  /**
   * Sets the file to be uploaded
   */
  public function setFile ($file) {
    $this->file = $file;
    return $this;
  }

  /**
   * Sets the path for the file to be uploaded to.
   */
  public function setPath ($path) {
    $this->path = $path;
    return $this;
  }

  /**
   * Check if the specified path is writable.
   */
  private function isWritable () {

    // If no path is provided
    if (!$this->path) {
      $this->setError('No path provided');
      return false;
    }

    if (!is_dir($this->path)) {
      $this->setError('Provided path is not a directory');
      return false;
    }

    // If it is not writable
    if (!is_writable($this->path)) {
      $this->setError('Provided path is not writable');
      return false;
    }

    return true;
  }

  /**
   * Construct the new path with the name appended.
   */
  private function constructFilePath ($name) {
    $path = rtrim($this->path, '/');
    return $path . '/' . $name;
  }

  /**
   * Generates a custom name if one is not
   * provided via the options.
   */
  private function generateFileName ($customName = false) {
    $extension = $this->getFileExtension();

    if (!$extension) {
      $this->setError('Could not extract an extension');
      return false;
    }

    return ($customName !== false ? $customName : md5(time())) . '.' . $this->getFileExtension();
  }

  /**
   * Get the file size
   */
  private function getFileSize () {
    if (!$this->file) return false;
    if (!isset($this->file['size'])) return false;
    return $this->file['size'];
  }

  /**
   * Get the extension of the file.
   */
  private function getFileExtension () {
    if (!$this->file) return false;
    if (!isset($this->file['name'])) return false;
    $extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
    return $extension;
  }

  /**
   * Sets the class error.
   */
  private function setError ($error) {
    $this->error = '\\Irate\\Core\\Uploader: ' . $error;
  }
}
