<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Allowed image mime types
     */
    const ALLOWED_IMAGE_MIMES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp'
    ];

    /**
     * Allowed document mime types
     */
    const ALLOWED_DOCUMENT_MIMES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    /**
     * Maximum file sizes in bytes
     */
    const MAX_IMAGE_SIZE = 2097152; // 2MB
    const MAX_DOCUMENT_SIZE = 10485760; // 10MB

    /**
     * Upload and validate an avatar image
     *
     * @param UploadedFile $file
     * @param string $type (student, teacher, school)
     * @return array
     */
    public function uploadAvatar(UploadedFile $file, string $type = 'user')
    {
        // Validate file
        $validation = $this->validateImageFile($file);
        if (!$validation['valid']) {
            return [
                'success' => false,
                'error' => $validation['error']
            ];
        }

        // Sanitize filename
        $filename = $this->generateSafeFilename($file);
        
        // Determine upload path
        $uploadPath = $this->getAvatarUploadPath($type);
        
        // Store file
        try {
            $path = $file->storeAs($uploadPath, $filename, 'public');
            
            return [
                'success' => true,
                'filename' => $filename,
                'path' => $path,
                'url' => Storage::url($path)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to upload file: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Upload and validate a document
     *
     * @param UploadedFile $file
     * @param string $type
     * @return array
     */
    public function uploadDocument(UploadedFile $file, string $type = 'general')
    {
        // Validate file
        $validation = $this->validateDocumentFile($file);
        if (!$validation['valid']) {
            return [
                'success' => false,
                'error' => $validation['error']
            ];
        }

        // Sanitize filename
        $filename = $this->generateSafeFilename($file);
        
        // Determine upload path
        $uploadPath = 'uploads/documents/' . $type;
        
        // Store file
        try {
            $path = $file->storeAs($uploadPath, $filename, 'public');
            
            return [
                'success' => true,
                'filename' => $filename,
                'path' => $path,
                'url' => Storage::url($path)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to upload file: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Validate an image file
     *
     * @param UploadedFile $file
     * @return array
     */
    private function validateImageFile(UploadedFile $file)
    {
        // Check if file exists
        if (!$file->isValid()) {
            return [
                'valid' => false,
                'error' => 'Invalid file upload'
            ];
        }

        // Check mime type
        if (!in_array($file->getMimeType(), self::ALLOWED_IMAGE_MIMES)) {
            return [
                'valid' => false,
                'error' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP images are allowed.'
            ];
        }

        // Check file size
        if ($file->getSize() > self::MAX_IMAGE_SIZE) {
            return [
                'valid' => false,
                'error' => 'File size exceeds maximum limit of 2MB'
            ];
        }

        // Additional security check - verify actual file content
        $imageInfo = @getimagesize($file->getRealPath());
        if (!$imageInfo) {
            return [
                'valid' => false,
                'error' => 'File is not a valid image'
            ];
        }

        return ['valid' => true];
    }

    /**
     * Validate a document file
     *
     * @param UploadedFile $file
     * @return array
     */
    private function validateDocumentFile(UploadedFile $file)
    {
        // Check if file exists
        if (!$file->isValid()) {
            return [
                'valid' => false,
                'error' => 'Invalid file upload'
            ];
        }

        // Check mime type
        if (!in_array($file->getMimeType(), self::ALLOWED_DOCUMENT_MIMES)) {
            return [
                'valid' => false,
                'error' => 'Invalid file type. Only PDF, Word, and Excel documents are allowed.'
            ];
        }

        // Check file size
        if ($file->getSize() > self::MAX_DOCUMENT_SIZE) {
            return [
                'valid' => false,
                'error' => 'File size exceeds maximum limit of 10MB'
            ];
        }

        return ['valid' => true];
    }

    /**
     * Generate a safe filename
     *
     * @param UploadedFile $file
     * @return string
     */
    private function generateSafeFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $timestamp = time();
        
        return "{$timestamp}_{$filename}.{$extension}";
    }

    /**
     * Get avatar upload path based on type
     *
     * @param string $type
     * @return string
     */
    private function getAvatarUploadPath(string $type)
    {
        switch ($type) {
            case 'student':
                return 'uploads/student_avatars';
            case 'teacher':
                return 'uploads/teacher_avatars';
            case 'school':
                return 'uploads/school_avatars';
            default:
                return 'uploads/avatars';
        }
    }

    /**
     * Delete a file
     *
     * @param string $path
     * @return bool
     */
    public function deleteFile(string $path)
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    /**
     * Check if file exists
     *
     * @param string $path
     * @return bool
     */
    public function fileExists(string $path)
    {
        return Storage::disk('public')->exists($path);
    }
}