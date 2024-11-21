import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { BookService } from '../../services/book.service';
import { Book } from '../../models/book.model';

@Component({
  standalone: true,
  selector: 'app-book-list',
  templateUrl: './book-list.component.html',
  styleUrls: ['./book-list.component.css'],
  imports: [CommonModule, FormsModule]
})
export class BookListComponent {
  books: Book[] = [];
  newBook: Book = { id: 0, title: '', author: '', genre: '', rating: 0, price: 0, coverImage: '' };
  isEditing: boolean = false;
  editingBookId: number | null = null;

  constructor(private bookService: BookService) {
    // اشتراک به داده‌ها
    this.bookService.getBooks().subscribe((books) => {
      this.books = books;
    });
  }

  // متد برای انتخاب فایل تصویر
  onFileSelected(event: any) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e: any) => {
        this.newBook.coverImage = e.target.result; // ذخیره تصویر به صورت Base64
      };
      reader.readAsDataURL(file);
    }
  }

  addBook() {
    if (this.newBook.title && this.newBook.author) {
      if (this.isEditing && this.editingBookId !== null) {
        this.bookService.updateBook({ ...this.newBook, id: this.editingBookId }).subscribe(() => {
          this.refreshBooks();
        });
        this.isEditing = false;
        this.editingBookId = null;
      } else {
        this.bookService.addBook(this.newBook).subscribe(() => {
          this.refreshBooks();
        });
      }
      this.newBook = { id: 0, title: '', author: '', genre: '', rating: 0, price: 0, coverImage: '' };
    }
  }

  editBook(book: Book) {
    this.newBook = { ...book };
    this.isEditing = true;
    this.editingBookId = book.id;
  }

  deleteBook(bookId: number) {
    this.bookService.deleteBook(bookId).subscribe(() => {
      this.refreshBooks();
    });
  }

  refreshBooks() {
    this.bookService.getBooks().subscribe((books) => {
      this.books = books;
    });
  }
}
