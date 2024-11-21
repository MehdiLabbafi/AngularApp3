export interface Book {
  id: number;
  title: string;
  author: string;
  genre: string;
  price: number;
  rating: number;
  coverImage?: string; // تصویر می‌تواند اختیاری باشد
}