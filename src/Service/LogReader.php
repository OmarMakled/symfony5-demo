<?php

namespace App\Service;

use Generator;
use InvalidArgumentException;

/**
 * @author Omar Makled <omar.makled@gmail.com>
 */
class LogReader
{
  /**
   * Open file from given path
   *
   * @param  string $filePath
   * @return Generator
   * @throws InvalidArgumentException
   */
  public function open(string $filePath): Generator
  {
    if (!$file = @fopen($filePath, 'r')) {
      throw new InvalidArgumentException('Can not open the file ' . $filePath);
    }

    return $this->read($file);
  }

  /**
   * Read given file
   *
   * @param  resource $file
   * @return Generator
   */
  private function read($file)
  {
    while (($line = fgets($file)) !== false) {
      yield $line;
    }

    fclose($file);
  }
}
