<?php

namespace Database\Seeders;

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Two-level taxonomy modelled on techshopbd.com: 'icon' is a key into
     * resources/views/components/icon.blade.php, 'blurb' shows in the mega menu.
     */
    const TAXONOMY = [
        ['Arduino', 'board', 'Boards, shields and official accessories', [
            'Arduino Board', 'Arduino Shield',
        ]],
        ['Development Board', 'cpu', 'Raspberry Pi, ARM, FPGA, AVR and PIC platforms', [
            'Raspberry Pi & Accessories', 'ARM Development Board', 'FPGA Development Board',
            'AVR Development Board', 'PIC Development Board', 'Other Development Board',
        ]],
        ['Microcontroller', 'chip', 'MCUs, programmers and data converters', [
            'AVR Microcontroller', 'PIC Microcontroller', 'ARM Microcontroller',
            'AVR Programmer', 'PIC Programmer', 'Data Converter',
            'Other Microcontrollers & Accessories',
        ]],
        ['ESP', 'wifi', 'WiFi-enabled ESP8266 and ESP32 modules', [
            'ESP8266', 'ESP32',
        ]],
        ['Sensor', 'radar', 'Measure light, motion, gas, temperature and more', [
            'Temperature', 'Light', 'Motion', 'Sound', 'Weight', 'Water', 'Pressure',
            'Moisture', 'Current', 'Gas', 'Flex', 'Gyro, Accelerometer & Compass',
            'Biometrics', 'Other Sensor',
        ]],
        ['Robotics', 'robot', 'Motors, drivers, wheels and chassis parts', [
            'Motor', 'Motor Driver', 'Actuator', 'Controller', 'Propeller',
            'Wheel & Caster', 'Robotics Sensor', 'Other Robotics',
        ]],
        ['Wireless Transceiver', 'antenna', 'Bluetooth, WiFi, RF, GSM and GPS links', [
            'Bluetooth', 'WiFi', 'RF', 'Xbee / Zigbee', 'GSM, GPS & GPRS', 'Antennas',
        ]],
        ['Display', 'monitor', 'LCD, OLED, E-Ink, LED panels and drivers', [
            'LCD, OLED & E-Ink', 'LED Panel', 'DOT Matrix', 'Multi Segment', 'Display Driver',
        ]],
        ['Basic Component', 'resistor', 'Passives, semiconductors and discrete parts', [
            'Resistor', 'Capacitor', 'Inductor', 'Diode', 'Transistor', 'MOSFET',
            'Regulator', 'LED', 'Laser', 'Buzzer', 'Optocoupler',
            'Thyristor / SCR', 'Diac & Triac',
        ]],
        ['General IC', 'ic', 'Logic families, op-amps, timers and memory', [
            'OPAMP', 'Timer & PWM', 'Gates', '74 Family', '4000 Family', 'Encoder', 'Decoder',
            'Driver', 'Converter', 'Transceiver', 'Inverter', 'LCD Driver',
            'Digital Rheostat', 'EEPROM', 'RTC', 'Other IC',
        ]],
        ['Instruments', 'gauge', 'Test, measurement and bench power gear', [
            'Digital Multimeters', 'Analog Multimeter', 'Digital Oscilloscopes',
            'Signal Generator', 'Signal Analyzer', 'Load Tester', 'Power Supply',
            'Measurement', 'Calculator',
        ]],
        ['Kits', 'kit', 'Starter, sensor, robotics and science bundles', [
            'Starter Kits', 'Sensor Kits', 'Robotic Kits', 'Advanced kits', 'Science Box',
        ]],
        ['3D Printer & Accessories', 'printer', 'Printers and filament for rapid prototyping', [
            '3D Printing Machines', '3D Printer Filament',
        ]],
        ['Drone', 'drone', 'Semi-professional and professional aerial kit', [
            'Semi Professional Drone', 'Professional Drone',
        ]],
        ['Home Automation', 'home', 'IoT devices, timers, switches and security', [
            'IoT Device', 'Security System', 'Automatic Light', 'Automatic Switch',
            'Timer', 'Remote', 'Appliance', 'Rechargeable Fan', 'IPS UPS Inverter',
        ]],
        ['Maintenance Tools', 'wrench', 'Hand tools for build, repair and rework', [
            'Tools',
        ]],
        ['Accessories', 'cable', 'Cables, connectors and computer peripherals', [
            'Cable', 'Connector', 'Computer Peripherals',
        ]],
        ['Computer & Accessories', 'desktop', 'Mini PCs and projectors', [
            'Mini PC', 'Projector',
        ]],
        ['Miscellaneous', 'grid', 'Power, prototyping and everything else', [
            'Battery', 'Charger', 'Solar', 'Generator', 'Breadboard', 'Soldering',
            'Switch & Button', 'Relay', 'DC Fan', 'Cooler', 'Pump', 'Solenoid',
            'Crystal Oscillator', 'Keypad', 'Memory Card', 'Audio', 'Magnet', 'Screw',
        ]],
    ];

    public function run()
    {
        $sort = 0;

        foreach (self::TAXONOMY as [$name, $icon, $blurb, $children]) {
            $parent = Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['parent_id' => null, 'name' => $name, 'icon' => $icon, 'blurb' => $blurb, 'sort_order' => $sort++],
            );

            $childSort = 0;
            foreach ($children as $childName) {
                Category::updateOrCreate(
                    ['slug' => Str::slug($name.' '.$childName)],
                    [
                        'parent_id' => $parent->id,
                        'name' => $childName,
                        'icon' => $icon,
                        'blurb' => null,
                        'sort_order' => $childSort++,
                    ],
                );
            }
        }
    }
}
