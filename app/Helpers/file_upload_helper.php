<?php
function uploadFile($file, $folder, $fileId)
{
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx','webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!$file->isValid()) {
        return ['error' => 'Invalid file upload.'];
    }

    $extension = $file->getExtension();
    if (!in_array(strtolower($extension), $allowedExtensions)) {
        return ['error' => 'Invalid file type. Allowed types: ' . implode(', ', $allowedExtensions)];
    }

    if ($file->getSize() > $maxSize) {
        return ['error' => 'File size exceeds 5MB limit.'];
    }

    $uploadPath = ROOTPATH . 'assets/uploads/' . $folder;
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    $newName = $fileId . '.' . $extension;
    if ($file->move($uploadPath, $newName)) {
        return ['path' => 'assets/uploads/' . $folder . '/' . $newName];
    }

    return ['error' => 'Failed to move uploaded file.'];
}
