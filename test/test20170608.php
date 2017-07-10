<?php

// class Car
// {
//   public static function model(){
//     static::getModel();
//   }

//   protected static function getModel(){
//     echo "This is a car model";
//   }
// }

// Car::model();

// Class Taxi extends Car
// {
//   protected static function getModel(){
//     echo "This is a Taxi model";
//   }
// }


// Taxi::model();
// exit;
// 得到输出

// This is a car model
// This is a car model
// 可以发现，self在子类中还是会调用父类的方法

// Demo for static
// class Car
// {
//   public static function model(){
//     static::getModel();
//   }

//   protected static function getModel(){
//     echo "This is a car model";
//   }
// }

// Car::model();

// Class Taxi extends Car
// {
//   protected static function getModel(){
//     echo "This is a Taxi model";
//   }
// }

// Taxi::model();
// 得到输出

// This is a car model
// This is a Taxi model
// 可以看到，在调用static，子类哪怕调用的是父类的方法，但是父类方法中调用的方法还会是子类的方法（好绕嘴。。）

// 在PHP5.3版本以前，static和self还是有一点区别，具体是什么，毕竟都是7版本的天下了。就不去了解了。

// 总结呢就是：self只能引用当前类中的方法，而static关键字允许函数能够在运行时动态绑定类中的方法。