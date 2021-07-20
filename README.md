[![\[Telegram\] tutorialsgroup](https://img.shields.io/badge/Telegram-Group-blue.svg?logo=telegram)](https://t.me/tutorialsgroup)
[![\[Telegram\] sobirjonovs](https://img.shields.io/badge/Telegram-blue.svg?logo=telegram)](https://t.me/sobirjonovs)

# Qisqacha qoʻllanma
Kichkina masshtabli botlar uchun optimal bot shablon

## Vaqtinchalik va doimiy ma'lumotlarni saqlash
Vaqtinchalik va doimiy ma'lumotlarni saqlash `storage/StorageManager` menejeri orqali amalga oshiriladi. Bu menejer barcha hendlerlarga biriktirilgan bo'lib, har bir hendlerni ichida `$this->storage` kabi ishlatsa bo'ladi. Ma'lumotlar `storage/files/storage.txt` faylida saqlanadi. 

## Hendlerlarga ajratish
Apdeytlarni boshqarish uchun `handlers/User` papkasidagi `user_handler.php` fayliga kerakli funksiyani yozish kerak. Batafsil `user_handler.php` faylida yozilgan.

## Global yordamchi funksiyalar yozish
Global yordamchi funksiyalarni `config/helpers.php` fayliga yozish mumkin

## Afzalliklar
- Obyektga yo'naltirilgan
- Tezkor ishlash
- Maxsus ma'lumotlar boshqaruv menejeri (StorageManager)
- Boshlang'ich shablon
- Ichki qurilgan regex
- va boshqalar

## Namuna kodlar
Namuna kodlarni ko'rish uchun `handlers/User/user_handler.php` faylini ko'ring. start hamda inline metodi `handlers/User/MessageHandler` hendlerga tegishli bo'lsa, data metodi `handlers/User/CallbackQueryHandler` hendlerga tegishli.

## /start bosganda
![image](https://user-images.githubusercontent.com/51774058/126250755-31f11d6a-5497-4a59-9a02-2cef04c335a4.png)

## /getinline bosganda
![image](https://user-images.githubusercontent.com/51774058/126250789-c9daa342-4a95-49c5-b1d9-620066471902.png)

## `"Inline 1"` tugmasi bosilganda
![image](https://user-images.githubusercontent.com/51774058/126250811-a6c08a1b-0f32-421e-b766-3cd8bce05d0d.png)
