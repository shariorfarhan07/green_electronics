<?php

namespace Database\Seeders;

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    protected $catalogue = [
        'development-boards' => [
            'name' => 'Development Boards',
            'icon' => 'chip',
            'blurb' => "Arduino, ESP32/8266, Raspberry Pi & microcontrollers",
            'items' => [
                ['Arduino Uno R3 (China)', 450],
                ['Arduino Nano V3.0 (CH340)', 320],
                ['ESP32 DevKit V1 WROOM-32', 480],
                ['Raspberry Pi 4 Model B (4GB)', 8500],
                ['NodeMCU ESP8266 V3 Lua', 260],
                ['STM32F103C8T6 Blue Pill', 240],
            ],
        ],
        'robotics-rc' => [
            'name' => 'Robotics & RC',
            'icon' => 'box',
            'blurb' => 'Motors, drivers, drones, transmitters & chassis',
            'items' => [
                ['TT Gear Motor with Wheel', 60],
                ['L298N Dual H-Bridge Motor Driver', 120],
                ['4-Channel RC Transmitter & Receiver', 1850],
                ['F450 Quadcopter Frame Kit', 950],
                ['MG90S Micro Servo Motor', 180],
            ],
        ],
        'sensors' => [
            'name' => 'Sensors',
            'icon' => 'shield',
            'blurb' => 'Motion, gas, temperature, weight & proximity',
            'items' => [
                ['PIR Motion Sensor HC-SR501', 90],
                ['Ultrasonic Distance Sensor HC-SR04', 80],
                ['DHT22 Temperature & Humidity Sensor', 450],
                ['MQ-2 Gas & Smoke Sensor Module', 110],
                ['IR Obstacle Avoidance Sensor', 45],
            ],
        ],
        'wireless-communication' => [
            'name' => 'Wireless & Communication',
            'icon' => 'chevron-right',
            'blurb' => 'GSM/GPS/GPRS, Bluetooth, WiFi & RF modules',
            'items' => [
                ['HC-05 Bluetooth Serial Module', 350],
                ['NRF24L01 2.4GHz Transceiver Module', 150],
                ['SIM800L GSM/GPRS Module', 650],
                ['NEO-6M GPS Module with Antenna', 750],
            ],
        ],
        'cnc-3d-printers' => [
            'name' => 'CNC & 3D Printers',
            'icon' => 'grid',
            'blurb' => 'Printers, filament, extruders & CNC parts',
            'items' => [
                ['Creality Ender-3 V2 3D Printer', 28500],
                ['PLA Filament 1.75mm (1kg)', 1450],
                ['NEMA17 Stepper Motor', 550],
                ['MK8 Extruder Hotend Kit', 650],
            ],
        ],
        'components' => [
            'name' => 'Components',
            'icon' => 'chip',
            'blurb' => 'Active & passive parts, ICs & semiconductors',
            'items' => [
                ['Resistor Kit (600pcs Assorted)', 250],
                ['Ceramic Capacitor Kit (Assorted)', 220],
                ['5mm LED Assorted Pack (100pcs)', 150],
                ['2N2222 NPN Transistor (10pcs)', 40],
                ['LM7805 Voltage Regulator (5pcs)', 50],
            ],
        ],
        'tools-hardware' => [
            'name' => 'Tools & Hardware',
            'icon' => 'filter',
            'blurb' => 'Soldering, measurement tools & mechanical hardware',
            'items' => [
                ['60W Soldering Iron Kit', 650],
                ['Digital Multimeter DT830B', 380],
                ['Mini Breadboard 400 Point', 90],
                ['Precision Screwdriver Set (32-in-1)', 420],
            ],
        ],
        'cables-connectors' => [
            'name' => 'Cables & Connectors',
            'icon' => 'plus',
            'blurb' => 'Jumper wires, headers, terminals & connectors',
            'items' => [
                ['Male-Female Jumper Wires (40pcs)', 90],
                ['Dupont Connector Housing Kit', 180],
                ['USB Type-C Cable 1m', 150],
                ['JST-XH 2.54mm Connector Set', 120],
            ],
        ],
        'home-automation' => [
            'name' => 'Home Automation',
            'icon' => 'shield',
            'blurb' => 'IoT relays, switches, timers & security',
            'items' => [
                ['4-Channel 5V Relay Module', 220],
                ['WiFi Smart Plug', 950],
                ['PIR Motion Sensor Light Switch', 380],
                ['IR Remote Control Kit', 150],
            ],
        ],
        'beginner-kits' => [
            'name' => 'Beginner Kits',
            'icon' => 'box',
            'blurb' => 'Starter kits & project bundles to get going fast',
            'items' => [
                ['Arduino Starter Kit for Beginners', 2200],
                ['ESP32 IoT Project Kit', 2600],
                ['Basic Electronics Component Box', 850],
                ['Robotics Starter Kit with Chassis', 1750],
            ],
        ],
    ];

    /**
     * Demo products are filed against the techshopbd-style leaf categories created by
     * CategorySeeder. First matching name fragment wins; groups fall back to a default leaf.
     */
    const LEAF_MAP = [
        'Arduino Uno R3' => 'arduino-arduino-board',
        'Arduino Nano' => 'arduino-arduino-board',
        'ESP32 DevKit' => 'esp-esp32',
        'Raspberry Pi 4' => 'development-board-raspberry-pi-accessories',
        'NodeMCU ESP8266' => 'esp-esp8266',
        'STM32F103C8T6' => 'development-board-arm-development-board',
        'TT Gear Motor' => 'robotics-motor',
        'L298N' => 'robotics-motor-driver',
        '4-Channel RC Transmitter' => 'robotics-controller',
        'F450 Quadcopter' => 'drone-semi-professional-drone',
        'MG90S Micro Servo' => 'robotics-actuator',
        'PIR Motion Sensor HC-SR501' => 'sensor-motion',
        'Ultrasonic Distance Sensor' => 'sensor-other-sensor',
        'DHT22' => 'sensor-temperature',
        'MQ-2' => 'sensor-gas',
        'IR Obstacle Avoidance' => 'sensor-other-sensor',
        'HC-05 Bluetooth' => 'wireless-transceiver-bluetooth',
        'NRF24L01' => 'wireless-transceiver-rf',
        'SIM800L' => 'wireless-transceiver-gsm-gps-gprs',
        'NEO-6M GPS' => 'wireless-transceiver-gsm-gps-gprs',
        'Creality Ender-3' => '3d-printer-accessories-3d-printing-machines',
        'PLA Filament' => '3d-printer-accessories-3d-printer-filament',
        'NEMA17 Stepper Motor' => 'robotics-motor',
        'MK8 Extruder' => '3d-printer-accessories-3d-printing-machines',
        'Resistor Kit' => 'basic-component-resistor',
        'Ceramic Capacitor Kit' => 'basic-component-capacitor',
        '5mm LED' => 'basic-component-led',
        '2N2222' => 'basic-component-transistor',
        'LM7805' => 'basic-component-regulator',
        '60W Soldering Iron' => 'miscellaneous-soldering',
        'Digital Multimeter DT830B' => 'instruments-digital-multimeters',
        'Mini Breadboard' => 'miscellaneous-breadboard',
        'Precision Screwdriver' => 'maintenance-tools-tools',
        'Male-Female Jumper Wires' => 'accessories-cable',
        'Dupont Connector' => 'accessories-connector',
        'USB Type-C Cable' => 'accessories-cable',
        'JST-XH' => 'accessories-connector',
        '4-Channel 5V Relay' => 'miscellaneous-relay',
        'WiFi Smart Plug' => 'home-automation-iot-device',
        'PIR Motion Sensor Light' => 'home-automation-automatic-light',
        'IR Remote Control Kit' => 'home-automation-remote',
        'Arduino Starter Kit' => 'kits-starter-kits',
        'ESP32 IoT Project Kit' => 'kits-starter-kits',
        'Basic Electronics Component' => 'kits-starter-kits',
        'Robotics Starter Kit' => 'kits-robotic-kits',
    ];

    const GROUP_FALLBACK = [
        'development-boards' => 'development-board-other-development-board',
        'robotics-rc' => 'robotics-other-robotics',
        'sensors' => 'sensor-other-sensor',
        'wireless-communication' => 'wireless-transceiver-rf',
        'cnc-3d-printers' => '3d-printer-accessories-3d-printing-machines',
        'components' => 'basic-component-resistor',
        'tools-hardware' => 'maintenance-tools-tools',
        'cables-connectors' => 'accessories-cable',
        'home-automation' => 'home-automation-iot-device',
        'beginner-kits' => 'kits-starter-kits',
    ];

    public function run()
    {
        Storage::disk('public')->makeDirectory('product_images');

        $now = now();
        $categoryIds = Category::pluck('id', 'slug');

        foreach ($this->catalogue as $slug => $data) {
            $image = $this->ensureCategoryImage($slug, $data['name']);

            foreach ($data['items'] as [$name, $price]) {
                $leaf = self::GROUP_FALLBACK[$slug] ?? null;
                foreach (self::LEAF_MAP as $needle => $target) {
                    if (stripos($name, $needle) !== false) { $leaf = $target; break; }
                }

                $productId = DB::table('products')->insertGetId([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'sku' => strtoupper(Str::random(3)).'-'.rand(1000, 9999),
                    'category_id' => $categoryIds[$leaf] ?? null,
                    'subcategory' => null,
                    'brand' => null,
                    'description' => "Genuine {$name} sourced for makers, students and engineers. Ideal for prototyping and project builds.",
                    'short_description' => "Category: {$data['name']}. Tested before dispatch.",
                    'specifications' => null,
                    'video_url' => null,
                    'sold' => rand(0, 220),
                    'stock' => rand(0, 120),
                    'price' => $price,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                DB::table('product_images')->insert([
                    'product_id' => $productId,
                    'path' => $image,
                    'sort_order' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    protected function ensureCategoryImage(string $slug, string $name): string
    {
        $filename = $slug.'.svg';
        $path = 'product_images/'.$filename;

        Storage::disk('public')->put($path, $this->buildSvg($slug, $name));

        return $filename;
    }

    protected function buildSvg(string $slug, string $name): string
    {
        $safe = htmlspecialchars($name, ENT_XML1);
        $icon = $this->iconFor($slug);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="600" height="600" viewBox="0 0 600 600">
  <rect width="600" height="600" fill="#f6f6f7"/>
  {$icon}
  <text x="300" y="470" font-family="-apple-system, Segoe UI, Inter, sans-serif" font-size="20" font-weight="700" fill="#111113" text-anchor="middle">{$safe}</text>
  <text x="300" y="497" font-family="-apple-system, Segoe UI, Inter, sans-serif" font-size="13" fill="#9a9ca3" text-anchor="middle">Green Electronics</text>
</svg>
SVG;
    }

    protected function iconFor(string $slug): string
    {
        $icons = [
            'development-boards' => '
                <rect x="220" y="210" width="160" height="110" rx="10" fill="#fff" stroke="#111113" stroke-width="4"/>
                <rect x="270" y="240" width="60" height="50" rx="4" fill="#157a4d"/>
                <line x1="240" y1="210" x2="240" y2="190" stroke="#111113" stroke-width="4"/>
                <line x1="265" y1="210" x2="265" y2="190" stroke="#111113" stroke-width="4"/>
                <line x1="335" y1="210" x2="335" y2="190" stroke="#111113" stroke-width="4"/>
                <line x1="360" y1="210" x2="360" y2="190" stroke="#111113" stroke-width="4"/>
                <line x1="240" y1="320" x2="240" y2="340" stroke="#111113" stroke-width="4"/>
                <line x1="265" y1="320" x2="265" y2="340" stroke="#111113" stroke-width="4"/>
                <line x1="335" y1="320" x2="335" y2="340" stroke="#111113" stroke-width="4"/>
                <line x1="360" y1="320" x2="360" y2="340" stroke="#111113" stroke-width="4"/>
                <circle cx="235" cy="225" r="5" fill="#111113"/>
                <circle cx="365" cy="225" r="5" fill="#111113"/>
            ',
            'robotics-rc' => '
                <rect x="230" y="250" width="140" height="60" rx="16" fill="#fff" stroke="#111113" stroke-width="4"/>
                <circle cx="260" cy="330" r="26" fill="#111113"/>
                <circle cx="260" cy="330" r="10" fill="#f6f6f7"/>
                <circle cx="340" cy="330" r="26" fill="#111113"/>
                <circle cx="340" cy="330" r="10" fill="#f6f6f7"/>
                <line x1="300" y1="250" x2="300" y2="215" stroke="#111113" stroke-width="4"/>
                <circle cx="300" cy="205" r="8" fill="#157a4d"/>
                <circle cx="270" cy="280" r="8" fill="#157a4d"/>
                <circle cx="330" cy="280" r="8" fill="#157a4d"/>
            ',
            'sensors' => '
                <rect x="240" y="270" width="120" height="70" rx="10" fill="#fff" stroke="#111113" stroke-width="4"/>
                <circle cx="300" cy="270" r="34" fill="#e7f5ee" stroke="#157a4d" stroke-width="4"/>
                <path d="M245 235 a80 80 0 0 1 110 0" fill="none" stroke="#157a4d" stroke-width="4"/>
                <path d="M225 210 a115 115 0 0 1 150 0" fill="none" stroke="#157a4d" stroke-width="3" opacity="0.5"/>
                <line x1="270" y1="340" x2="270" y2="360" stroke="#111113" stroke-width="4"/>
                <line x1="300" y1="340" x2="300" y2="360" stroke="#111113" stroke-width="4"/>
                <line x1="330" y1="340" x2="330" y2="360" stroke="#111113" stroke-width="4"/>
            ',
            'wireless-communication' => '
                <rect x="270" y="300" width="60" height="40" rx="8" fill="#fff" stroke="#111113" stroke-width="4"/>
                <line x1="300" y1="300" x2="300" y2="230" stroke="#111113" stroke-width="5"/>
                <circle cx="300" cy="222" r="8" fill="#157a4d"/>
                <path d="M255 245 a63 63 0 0 1 90 0" fill="none" stroke="#157a4d" stroke-width="4"/>
                <path d="M235 220 a95 95 0 0 1 130 0" fill="none" stroke="#157a4d" stroke-width="3" opacity="0.55"/>
                <path d="M215 195 a127 127 0 0 1 170 0" fill="none" stroke="#157a4d" stroke-width="3" opacity="0.3"/>
            ',
            'cnc-3d-printers' => '
                <line x1="230" y1="215" x2="370" y2="215" stroke="#111113" stroke-width="4"/>
                <line x1="300" y1="215" x2="300" y2="255" stroke="#111113" stroke-width="4"/>
                <path d="M285 255 h30 l-15 25 z" fill="#157a4d"/>
                <rect x="245" y="280" width="110" height="80" rx="6" fill="none" stroke="#111113" stroke-width="4"/>
                <line x1="245" y1="300" x2="355" y2="300" stroke="#111113" stroke-width="2"/>
                <line x1="245" y1="320" x2="355" y2="320" stroke="#111113" stroke-width="2"/>
                <line x1="245" y1="340" x2="355" y2="340" stroke="#111113" stroke-width="2"/>
            ',
            'components' => '
                <line x1="215" y1="290" x2="255" y2="290" stroke="#111113" stroke-width="4"/>
                <rect x="255" y="270" width="90" height="40" rx="8" fill="#fff" stroke="#111113" stroke-width="4"/>
                <rect x="270" y="270" width="10" height="40" fill="#d9a300"/>
                <rect x="290" y="270" width="10" height="40" fill="#d9463a"/>
                <rect x="310" y="270" width="10" height="40" fill="#157a4d"/>
                <line x1="345" y1="290" x2="385" y2="290" stroke="#111113" stroke-width="4"/>
                <line x1="300" y1="330" x2="300" y2="358" stroke="#111113" stroke-width="4"/>
                <line x1="282" y1="330" x2="318" y2="330" stroke="#111113" stroke-width="5"/>
                <line x1="282" y1="345" x2="318" y2="345" stroke="#111113" stroke-width="5"/>
            ',
            'tools-hardware' => '
                <g transform="rotate(-25 300 270)">
                    <rect x="260" y="260" width="120" height="20" rx="10" fill="#111113"/>
                    <circle cx="255" cy="270" r="22" fill="none" stroke="#111113" stroke-width="10"/>
                </g>
                <g transform="rotate(35 300 270)">
                    <rect x="290" y="262" width="90" height="16" rx="8" fill="#157a4d"/>
                    <rect x="220" y="260" width="32" height="20" rx="4" fill="#111113"/>
                </g>
            ',
            'cables-connectors' => '
                <rect x="205" y="278" width="45" height="26" rx="4" fill="#111113"/>
                <line x1="250" y1="291" x2="350" y2="239" stroke="#157a4d" stroke-width="6"/>
                <rect x="350" y="226" width="45" height="26" rx="4" fill="#111113"/>
                <circle cx="227" cy="291" r="4" fill="#f6f6f7"/>
                <circle cx="373" cy="239" r="4" fill="#f6f6f7"/>
            ',
            'home-automation' => '
                <rect x="265" y="260" width="70" height="90" rx="14" fill="#fff" stroke="#111113" stroke-width="4"/>
                <line x1="285" y1="350" x2="285" y2="372" stroke="#111113" stroke-width="6"/>
                <line x1="315" y1="350" x2="315" y2="372" stroke="#111113" stroke-width="6"/>
                <circle cx="300" cy="295" r="14" fill="#e7f5ee" stroke="#157a4d" stroke-width="4"/>
                <path d="M275 245 a35 35 0 0 1 50 0" fill="none" stroke="#157a4d" stroke-width="4"/>
            ',
            'beginner-kits' => '
                <path d="M235 250 L300 220 L365 250 L365 320 L300 350 L235 320 Z" fill="#fff" stroke="#111113" stroke-width="4"/>
                <path d="M235 250 L300 280 L365 250" fill="none" stroke="#111113" stroke-width="4"/>
                <line x1="300" y1="280" x2="300" y2="350" stroke="#111113" stroke-width="4"/>
                <circle cx="300" cy="255" r="10" fill="#157a4d"/>
            ',
        ];

        return $icons[$slug] ?? '<circle cx="300" cy="270" r="70" fill="#e7f5ee" stroke="#157a4d" stroke-width="4"/>';
    }
}
