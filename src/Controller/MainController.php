<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/circle/{radius}', name: 'circle')]
    public function index(Request $request): Response
    {
        $request = (float)$request->get('radius');
        $circle = new Circle();
        $circle = $circle->circles($request);
        return $this->json($circle);
    }

    #[Route('/triangle/{a}/{b}/{c}', name: 'triangle')]
    public function triangle(Request $request): Response
    {
        $a = (float)$request->get('a');
        $b = (float)$request->get('b');
        $c = (float)$request->get('c');
        $parameter = ['a' => $a, 'b' => $b, 'c' => $c];
        $triangle = new Triangle();
        $triangle = $triangle->triangles($parameter);
        return $this->json($triangle);
    }
}

class Shape {
    public static function geometry_calculator($data, $shape) {
        if ($shape == 'circle')
            $area =  round(pi() * pow($data, 2), 2);
        else
            $area = ($data['a'] + $data['b'] + $data['c']) / 2;

        return $area;
    }
}

class Circle {
    public function circles($radius) {
        $surface = Shape::geometry_calculator($radius, 'circle');
        $circumference = round(2 * pi() * $radius, 2);
        $data = [
            'type' => 'circle',
            'radius' => $radius,
            'surface' => $surface,
            'circumference' => $circumference
        ];

        return $data;
    }
}

class Triangle {
    public function triangles($parameter) {
        $surface = Shape::geometry_calculator($parameter, 'triangle');
        $circumference = $surface * 2;
        $data = [
            'type' => 'triangle',
            'a' => $parameter['a'],
            'b' => $parameter['b'],
            'c' => $parameter['c'],
            'surface' => $surface,
            'circumference' => $circumference
        ];
        return $data;
    }
}
