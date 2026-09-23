import React, { useEffect, useRef } from 'react';

// Interactive dot-grid background: sonar rings expand from wherever you click,
// ambient pings fire on their own, and one ring is already mid-flight on the
// first frame so the surface is never static on arrival.
//
// Everything is drawn on one canvas — a dot per grid cell scales and brightens
// as a ring's wavefront sweeps past it. No dependencies, no DOM per dot.
export default function SonarGrid({
    spacing = 26,       // px between dots
    dotRadius = 1.5,    // px radius of a resting dot
    baseOpacity = 0.32, // resting dot opacity
    ringWidth = 90,     // px thickness of a wavefront's influence
    speed = 260,        // px/sec a ring expands
    amplitude = 2.2,    // peak dot scale at the wavefront
    pingEvery = 2.4,    // seconds between ambient pings
    interactive = true,
    color,              // defaults to the theme accent
}) {
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        if (!canvas) return;
        const ctx = canvas.getContext('2d');

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const accent = (color
            || getComputedStyle(document.documentElement).getPropertyValue('--accent').trim()
            || '#157a4d');
        const rgb = toRgb(accent);

        let width = 0;
        let height = 0;
        let rings = [];
        let raf = null;
        let pingTimer = 0;
        let last = performance.now();

        function resize() {
            const dpr = Math.min(window.devicePixelRatio || 1, 2);
            const rect = canvas.getBoundingClientRect();
            width = rect.width;
            height = rect.height;
            canvas.width = Math.max(1, Math.floor(width * dpr));
            canvas.height = Math.max(1, Math.floor(height * dpr));
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        }

        function addRing(x, y) {
            rings.push({ x, y, r: 0 });
        }

        function ambientPing() {
            // Bias ambient pings away from the dead centre, where the card sits.
            const edge = Math.random() < 0.5;
            const x = edge ? Math.random() * width * 0.3 : width - Math.random() * width * 0.3;
            const y = Math.random() * height;
            addRing(x, y);
        }

        function draw(now) {
            const dt = Math.min((now - last) / 1000, 0.05);
            last = now;

            ctx.clearRect(0, 0, width, height);

            if (!reduceMotion) {
                pingTimer += dt;
                if (pingTimer >= pingEvery) {
                    pingTimer = 0;
                    ambientPing();
                }
                for (const ring of rings) ring.r += speed * dt;
                // A ring is spent once its wavefront has cleared the far corner.
                const maxR = Math.hypot(width, height) + ringWidth;
                rings = rings.filter((ring) => ring.r < maxR);
            }

            const cols = Math.ceil(width / spacing);
            const rows = Math.ceil(height / spacing);
            const offsetX = (width - (cols - 1) * spacing) / 2;
            const offsetY = (height - (rows - 1) * spacing) / 2;

            for (let i = 0; i < cols; i++) {
                for (let j = 0; j < rows; j++) {
                    const x = offsetX + i * spacing;
                    const y = offsetY + j * spacing;

                    // Strongest influence from any single passing wavefront.
                    let energy = 0;
                    for (const ring of rings) {
                        const d = Math.abs(Math.hypot(x - ring.x, y - ring.y) - ring.r);
                        if (d < ringWidth) {
                            // Cosine falloff: peaks exactly on the wavefront.
                            const e = (Math.cos((d / ringWidth) * Math.PI) + 1) / 2;
                            if (e > energy) energy = e;
                        }
                    }

                    const scale = 1 + (amplitude - 1) * energy;
                    const alpha = baseOpacity + (1 - baseOpacity) * energy;
                    const radius = dotRadius * scale;

                    ctx.beginPath();
                    ctx.arc(x, y, radius, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(${rgb}, ${alpha})`;
                    ctx.fill();
                }
            }

            raf = requestAnimationFrame(draw);
        }

        function onPointerDown(e) {
            const rect = canvas.getBoundingClientRect();
            addRing(e.clientX - rect.left, e.clientY - rect.top);
        }

        resize();
        // One ring already in flight at first paint.
        if (!reduceMotion) rings.push({ x: width * 0.5, y: height * 0.5, r: Math.hypot(width, height) * 0.25 });

        raf = requestAnimationFrame(draw);
        window.addEventListener('resize', resize);
        if (interactive && !reduceMotion) window.addEventListener('pointerdown', onPointerDown);

        return () => {
            cancelAnimationFrame(raf);
            window.removeEventListener('resize', resize);
            window.removeEventListener('pointerdown', onPointerDown);
        };
    }, [spacing, dotRadius, baseOpacity, ringWidth, speed, amplitude, pingEvery, interactive, color]);

    return <canvas ref={canvasRef} className="wb-sonar-grid" aria-hidden="true" />;
}

// Accepts the #rrggbb / #rgb the theme variable holds and returns "r, g, b".
function toRgb(value) {
    const hex = value.replace('#', '').trim();
    if (hex.length === 3) {
        const [r, g, b] = hex.split('');
        return [parseInt(r + r, 16), parseInt(g + g, 16), parseInt(b + b, 16)].join(', ');
    }
    if (hex.length === 6) {
        return [
            parseInt(hex.slice(0, 2), 16),
            parseInt(hex.slice(2, 4), 16),
            parseInt(hex.slice(4, 6), 16),
        ].join(', ');
    }
    return '21, 122, 77';
}
