@props(['name', 'size' => 20])
@php
$paths = [
    'search' => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
    'cart' => '<circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2.5 3h2l2.4 12.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 8H6.2"/>',
    'heart' => '<path d="M12 20.5s-7.5-4.6-10-9.3C.4 8 2 4.5 5.5 4a5 5 0 0 1 6.5 2.4A5 5 0 0 1 18.5 4c3.5.5 5.1 4 3.5 7.2-2.5 4.7-10 9.3-10 9.3Z"/>',
    'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>',
    'menu' => '<path d="M3 6h18M3 12h18M3 18h18"/>',
    'close' => '<path d="M6 6l12 12M18 6 6 18"/>',
    'chevron-right' => '<path d="m9 6 6 6-6 6"/>',
    'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
    'chevron-left' => '<path d="m15 18-6-6 6-6"/>',
    'star' => '<path d="m12 3 2.6 5.8 6.2.6-4.7 4.2 1.4 6.2L12 16.9l-5.5 2.9 1.4-6.2-4.7-4.2 6.2-.6Z"/>',
    'pin' => '<path d="M12 21s-7-6.1-7-11.5A7 7 0 0 1 19 9.5C19 14.9 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/>',
    'mail' => '<rect x="3" y="5" width="18" height="14" rx="1.5"/><path d="m4 6.5 8 6 8-6"/>',
    'phone' => '<path d="M5 4h3.2l1.4 4.4-2 1.6a12 12 0 0 0 6.4 6.4l1.6-2 4.4 1.4V19a2 2 0 0 1-2.1 2C10.5 20.6 3.4 13.5 3 6.1A2 2 0 0 1 5 4Z"/>',
    'plus' => '<path d="M12 5v14M5 12h14"/>',
    'minus' => '<path d="M5 12h14"/>',
    'trash' => '<path d="M4 7h16M9 7V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2m-8 0 1 12.5a1 1 0 0 0 1 .9h6a1 1 0 0 0 1-.9L18 7"/>',
    'check' => '<path d="m4 12 6 6L20 6"/>',
    'facebook' => '<path d="M14 21v-8h2.7l.4-3.4H14V7.4c0-1 .3-1.6 1.7-1.6H17V2.7C16.7 2.6 15.7 2.5 14.6 2.5c-2.3 0-3.9 1.4-3.9 4v2.1H8v3.4h2.7V21Z"/>',
    'instagram' => '<rect x="3" y="3" width="18" height="18" rx="4.5"/><circle cx="12" cy="12" r="3.7"/><circle cx="17.3" cy="6.7" r="1"/>',
    'youtube' => '<rect x="2.5" y="5.5" width="19" height="13" rx="3"/><path d="m10.5 9 5 3-5 3Z"/>',
    'whatsapp' => '<path d="M6.5 17.5 4 20l2.6-.7A8 8 0 1 0 4 12a7.9 7.9 0 0 0 1.1 4Z"/><path d="M9.2 9.6c.2-.5.4-.5.6-.5h.5c.2 0 .4 0 .5.4l.7 1.7c.1.2 0 .4-.1.6l-.5.5c-.1.2-.2.3 0 .6.3.5 1.3 1.6 2.5 2.1.2.1.4.1.5-.1l.5-.6c.2-.2.3-.2.5-.1l1.6.8c.2.1.3.2.3.4 0 .6-.6 1.4-1.2 1.6-1 .3-2 .3-4.3-.8-2-1-3.2-3.1-3.3-3.3-.1-.2-.9-1.2-.9-2.4 0-1.1.6-1.7.8-2Z"/>',
    'truck' => '<rect x="2" y="7" width="12" height="9" rx="1"/><path d="M14 10h3.5L20 12.8V16h-6Z"/><circle cx="6.5" cy="18" r="1.6"/><circle cx="16.5" cy="18" r="1.6"/>',
    'shield' => '<path d="M12 3.5 5 6v5.5c0 4.6 3 7.4 7 9 4-1.6 7-4.4 7-9V6Z"/><path d="m9.3 12 1.9 1.9L15 10"/>',
    'reply' => '<path d="M8 6 3 11l5 5M3 11h9.5a5.5 5.5 0 0 1 5.5 5.5V18"/>',
    'grid' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
    'filter' => '<path d="M4 5h16M7 12h10M10 19h4"/>',
    'box' => '<path d="M3.5 7.5 12 3l8.5 4.5v9L12 21l-8.5-4.5Z"/><path d="M3.5 7.5 12 12l8.5-4.5M12 12v9"/>',
    'chip' => '<rect x="6" y="6" width="12" height="12" rx="1.5"/><rect x="9.5" y="9.5" width="5" height="5"/><path d="M9 2v3M15 2v3M9 19v3M15 19v3M2 9h3M2 15h3M19 9h3M19 15h3"/>',
    'github' => '<path d="M9 19c-4.3 1.4-4.3-2.5-6-3m12 5v-3.5c0-1 .1-1.4-.5-2 2.8-.3 5.5-1.4 5.5-6a4.6 4.6 0 0 0-1.3-3.2 4.2 4.2 0 0 0-.1-3.2s-1.1-.3-3.5 1.3a12.3 12.3 0 0 0-6.4 0C6.5 2.8 5.4 3.1 5.4 3.1a4.2 4.2 0 0 0-.1 3.2A4.6 4.6 0 0 0 4 9.5c0 4.6 2.7 5.7 5.5 6-.6.6-.6 1.2-.5 2V21"/>',
    'lock' => '<rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>',
    'edit' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>',
    'image' => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9.5" r="1.6"/><path d="m21 15-5-5-9 9"/>',
];
$d = $paths[$name] ?? $paths['box'];
@endphp
<svg xmlns="http://www.w3.org/2000/svg" width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="wb-icon" aria-hidden="true">{!! $d !!}</svg>
