<?php

if (! function_exists('uploadImage')) {
    /**
     * Upload an image and return its storage path.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string|null
     */
    function uploadImage($file, $folder = 'uploads')
    {
        // Ensure a file was provided.
        if (!$file) {
            return null;
        }

        // Generate a unique filename with the original extension.
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Store the file in the specified folder on the 'public' disk.
        $path = $file->storeAs($folder, $filename, 'public');

        return $path;
    }
}
