import React, { useState } from 'react';
import Icon from '../Icon';

// Single-file picker with drag-and-drop, showing the chosen file's name.
export default function FileDropzone({ file, onChange, accept = '.csv,text/csv,application/vnd.ms-excel' }) {
    const [dragOver, setDragOver] = useState(false);

    return (
        <label
            className={`wb-admin__dropzone ${dragOver ? 'is-dragover' : ''}`}
            onDragEnter={(e) => { e.preventDefault(); setDragOver(true); }}
            onDragOver={(e) => { e.preventDefault(); setDragOver(true); }}
            onDragLeave={(e) => { e.preventDefault(); setDragOver(false); }}
            onDrop={(e) => {
                e.preventDefault();
                setDragOver(false);
                const dropped = e.dataTransfer?.files?.[0];
                if (dropped) onChange(dropped);
            }}
        >
            <input
                type="file"
                accept={accept}
                hidden
                onChange={(e) => { onChange(e.target.files?.[0] || null); e.target.value = ''; }}
            />
            {file ? (
                <div className="wb-admin__dropzone-selected">
                    <Icon name="check" size={18} />
                    <span>{file.name}</span>
                    <button
                        type="button"
                        className="wb-admin__icon-btn wb-admin__icon-btn--danger"
                        title="Remove file"
                        onClick={(e) => { e.preventDefault(); e.stopPropagation(); onChange(null); }}
                    >
                        <Icon name="close" size={13} />
                    </button>
                </div>
            ) : (
                <div>
                    <Icon name="box" size={26} />
                    <p style={{ margin: '.6rem 0 0' }}><strong>Click to choose</strong> or drag and drop your CSV file here</p>
                </div>
            )}
        </label>
    );
}
