<?php

namespace Controllers;

use MVC\Router;

class PortfolioController
{
    public static function index(Router $router)
    {
        // --- Servicios (sección "Del problema al producto") ---
        $servicios = [
            [
                'num'   => '01',
                'titulo'=> 'Desarrollo de software',
                'desc'  => 'HTML, CSS y JavaScript. Llevo el diseño hasta el producto vivo y funcional, del prototipo al código en producción.',
                'tags'  => ['Front-end', 'Responsive', 'Animación'],
            ],
            [
                'num'   => '02',
                'titulo'=> 'UX/UI Design',
                'desc'  => 'Interfaces claras, jerárquicas y accesibles. Diseño pensado en personas reales, no en suposiciones.',
                'tags'  => ['Design Systems', 'Accesibilidad', 'Figma'],
            ],
            [
                'num'   => '03',
                'titulo'=> 'Estrategia digital',
                'desc'  => 'Contenido, posicionamiento y decisiones de producto con visión de negocio y comunicación.',
                'tags'  => ['Contenido', 'Marca', 'Producto'],
            ],
            [
                'num'   => '04',
                'titulo'=> 'Automatizaciones',
                'desc'  => 'Flujos que ahorran horas: integro herramientas y proceso tareas repetitivas para que el trabajo se haga solo.',
                'tags'  => ['Workflows', 'Integraciones', 'APIs'],
            ],
            [
                'num'   => '05',
                'titulo'=> 'SEO',
                'desc'  => 'Posicionamiento orgánico con base técnica: estructura, contenido y rendimiento para que te encuentren.',
                'tags'  => ['SEO técnico', 'Contenido', 'Analítica'],
            ],
        ];

        // --- Credenciales (sección "La curiosidad, certificada") ---
        // 'radius' aplica esquinas redondeadas al logo (formatos .jpg con fondo).
        // 'extra' es una línea adicional opcional antes del nombre de la institución.
        $credenciales = [
            ['logo' => 'google.png',            'alt' => 'Google',                     'radius' => false, 'fecha' => '2024 · 2022', 'titulo' => 'UX Design Professional Certificate',   'extra' => '+ IT Support Professional Certificate — ', 'inst' => 'Google'],
            ['logo' => 'meta.jpg',              'alt' => 'Meta',                       'radius' => true,  'fecha' => '2025',        'titulo' => 'Principles of UX/UI Design',           'extra' => '', 'inst' => 'Meta'],
            ['logo' => 'universityoflondon.png','alt' => 'University of London',        'radius' => false, 'fecha' => '2025',        'titulo' => 'Responsive Web Design',                'extra' => '', 'inst' => 'University of London'],
            ['logo' => 'adobe.jpg',             'alt' => 'Adobe',                      'radius' => true,  'fecha' => '2025',        'titulo' => 'Design Fundamentals with AI',          'extra' => '', 'inst' => 'Adobe'],
            ['logo' => 'stanford.jpg',          'alt' => 'Stanford University',        'radius' => true,  'fecha' => '2025',        'titulo' => 'The AI Awakening: Economy &amp; Society','extra' => '', 'inst' => 'Stanford University'],
            ['logo' => 'IBM.png',               'alt' => 'IBM',                        'radius' => false, 'fecha' => '2024',        'titulo' => 'Generative AI Essentials',             'extra' => '', 'inst' => 'IBM'],
            ['logo' => 'politecnico.png',       'alt' => 'Politecnico di Milano',      'radius' => false, 'fecha' => '2025',        'titulo' => 'Ethics of AI',                         'extra' => '', 'inst' => 'Politecnico di Milano'],
            ['logo' => 'upenn.jpg',             'alt' => 'University of Pennsylvania', 'radius' => true,  'fecha' => '2025',        'titulo' => 'Philosophy of Science',                'extra' => '', 'inst' => 'University of Pennsylvania'],
            ['logo' => 'mindshop.png',          'alt' => 'Mindshop',                   'radius' => false, 'fecha' => '2025 · 2023', 'titulo' => 'History of Philosophy: Ethics',        'extra' => '+ Ancient Greek Philosophy — ', 'inst' => 'Mindshop'],
        ];

        // --- Instituciones (marquee) ---
        $instituciones = [
            'Google', 'Meta', 'Stanford University', 'IBM', 'University of London',
            'Adobe', 'Politecnico di Milano', 'University of Pennsylvania',
            'University of Oxford', 'Universidad Anáhuac', 'UNAM', 'Mindshop',
        ];

        // --- Cursos (docencia) ---
        $cursos = [
            [
                'num'       => '01',
                'img'       => 'word.jpg',
                'alt'       => 'Curso de Microsoft Word',
                'categoria' => 'OFIMÁTICA · CURSO',
                'titulo'    => 'Microsoft Word',
                'desc'      => 'De cero a experto en documentos profesionales: estilos, plantillas, tablas y combinación de correspondencia.',
                'href'      => 'https://www.udemy.com/course/microsoft-office-word-de-0-a-experto/?referralCode=CB4E993CF67872D20056',
            ],
            [
                'num'       => '02',
                'img'       => 'excel.jpg',
                'alt'       => 'Curso de Microsoft Excel',
                'categoria' => 'DATOS · CURSO',
                'titulo'    => 'Microsoft Excel',
                'desc'      => 'Ejercicios del mundo real: fórmulas, funciones, tablas dinámicas y análisis de datos aplicado a casos concretos.',
                'href'      => 'https://www.udemy.com/course/excel-completo-aprende-con-ejercicios-reales/?referralCode=78B6DE3ED2E62F7E49B8',
            ],
        ];

        // --- Blog ---
        $posts = [
            [
                'cover'     => 'repeating-linear-gradient(45deg,rgba(255,255,255,.06) 0 2px,transparent 2px 15px),linear-gradient(135deg,var(--accent) 0%,#1a0207 55%,#0b0b0c 100%)',
                'categoria' => 'PROCESO',
                'fecha'     => 'JUN · 6 MIN',
                'titulo'    => 'Priorizar features sin morir en el intento',
                'desc'      => 'Un marco simple para decidir qué construir primero cuando todo parece urgente y el roadmap crece más rápido que el equipo.',
            ],
            [
                'cover'     => 'radial-gradient(rgba(255,255,255,.14) 1px,transparent 1.6px) 0 0/17px 17px,radial-gradient(130% 130% at 24% 18%,var(--accent) 0%,#1a0207 52%,#0b0b0c 100%)',
                'categoria' => 'INVESTIGACIÓN',
                'fecha'     => 'MAY · 8 MIN',
                'titulo'    => '5 señales de que tu research está sesgado',
                'desc'      => 'Preguntas que inducen la respuesta, muestras cómodas y conclusiones que ya tenías antes de empezar. Cómo detectarlas a tiempo.',
            ],
            [
                'cover'     => 'repeating-linear-gradient(90deg,rgba(255,255,255,.05) 0 1px,transparent 1px 13px),linear-gradient(115deg,#0b0b0c 18%,#1a0207 55%,var(--accent) 100%)',
                'categoria' => 'CÓDIGO',
                'fecha'     => 'ABR · 5 MIN',
                'titulo'    => 'Del Figma al navegador sin perder el alma',
                'desc'      => 'Handoff, tokens y las decisiones que hacen que el producto vivo se sienta igual de cuidado que el prototipo.',
            ],
        ];

        $router->render('portfolio/index', [
            'titulo'        => 'Alexander Oliva — Desarrollador de Software & Diseñador UX/UI en CDMX',
            'servicios'     => $servicios,
            'credenciales'  => $credenciales,
            'instituciones' => $instituciones,
            'cursos'        => $cursos,
            'posts'         => $posts,
        ], 'portfolio-layout');
    }
}
