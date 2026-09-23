import React, { useState } from 'react';
import Icon from '../Icon';

// Multi-image picker with drag-and-drop. Inertia posts the File objects
// straight from state, so unlike a plain form there's no hidden <input> whose
// FileList has to be kept in sync.
export default function ImageDropzone({ files = [], onChange }) {
    const [dragOver, setDragOver] = useState(false);

    function addFiles(fileList) {
        const images = Array.from(fileList).filter((f) => f.type.startsWith('image/'));
        if (images.length) onChange([...files, ...images]);
    }

    function removeAt(index) {
        onChange(files.filter((_, i) => i !== index));
    }

    return (
        <>
            <label
                className={`wb-admin__dropzone ${dragOver ? 'is-dragover' : ''}`}
                onDragEnter={(e) => { e.preventDefault(); setDragOver(true); }}
                onDragOver={(e) => { e.preventDefault(); setDragOver(true); }}
                onDragLeave={(e) => { e.preventDefault(); setDragOver(false); }}
                onDrop={(e) => {
                    e.preventDefault();
                    setDragOver(false);
                    if (e.dataTransfer?.files) addFiles(e.dataTransfer.files);
                }}
            >
                <Icon name="image" size={28} />
                <p className="mb-0" style={{ marginTop: '.5rem' }}>Drag &amp; drop images here, or click to browse</p>
                <small style={{ color: 'var(--ink-faint)' }}>JPG, PNG or WebP, up to 2MB each.</small>
                <input
                    type="file"
                    multiple
                    accept="image/png,image/jpeg,image/webp"
                    hidden
                    onChange={(e) => { addFiles(e.target.files); e.target.value = ''; }}
                />
            </label>

            {files.length > 0 && (
                <div className="wb-admin__image-grid mt-3">
                    {files.map((file, index) => (
                        <div className="wb-admin__image-tile" key={`${file.name}-${index}`}>
                            <img src={URL.createObjectURL(file)} alt={file.name} />
                            {index === 0 && <span className="wb-admin__badge wb-admin__image-primary">Primary</span>}
                            <button
                                type="button"
                                className="wb-admin__icon-btn wb-admin__icon-btn--danger wb-admin__image-remove"
                                onClick={() => removeAt(index)}
                            >
                                &times;
                            </button>
                        </div>
                    ))}
                </div>
            )}
        </>
    );
}
