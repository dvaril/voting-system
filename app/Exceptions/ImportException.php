<?php

declare(strict_types = 1);

namespace App\Exceptions;

final class ImportException extends \Exception
{

    /**
     * @param  string $filePath
     * @return self
     */
    public static function fileDoesntExist(string $filePath): self
    {
        return new self(sprintf('File "%s" does not exist.', $filePath));
    }

    /**
     * @param  string $filePath
     * @param  string $fileExtension
     * @param  list<string> $allowedFileExtensions
     * @return self
     */
    public static function invalidFileExtension(string $filePath, string $fileExtension, array $allowedFileExtensions): self
    {
        return new self(sprintf(
            "The provided file '%s' has an invalid file extension '%s', allowed file extensions '%s'",
            $filePath,
            $fileExtension,
            implode(', ', $allowedFileExtensions)
        ));
    }

    /**
     * @param  string $column
     * @param  list<string> $existingColumns
     * @return self
     */
    public static function columnNotFoundInSheet(string $column, array $existingColumns): self
    {
        return new self(sprintf(
            "The column '%s' was not found in the provided import file, existing columns '%s'",
            $column,
            implode(', ', $existingColumns)
        ));
    }
}
