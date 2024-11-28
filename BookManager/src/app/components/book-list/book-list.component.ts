import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { BookService } from '../../services/book.service';
import { Book } from '../../models/book.model';
import { HttpClient } from '@angular/common/http';

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
  selectedFile: File | null = null; // For storing the selected file

  constructor(private bookService: BookService, private http: HttpClient) {
    // Subscribe to book data
    this.bookService.getBooks().subscribe((books) => {
      this.books = books;
    });
  }

  // Method for selecting a file
  onFileSelected(event: any) {
    const file = event.target.files[0];
    if (file) {
      this.selectedFile = file; // Store the selected file
    }
  }

  addBook() {
    if (this.newBook.title && this.newBook.author) {
      if (this.selectedFile) {
        // Use FormData to send the file to `upload_image.php`
        const formData = new FormData();
        formData.append('file', this.selectedFile);
        formData.append('title', this.newBook.title);
        formData.append('author', this.newBook.author);
        formData.append('genre', this.newBook.genre);
        formData.append('price', this.newBook.price.toString());
        formData.append('rating', this.newBook.rating.toString());

        this.http.post<{ success: boolean; filePath: string }>('http://localhost/BookManagerAPI/books.php', formData)
          .subscribe(response => {
            if (response.success) {
              // Save the file path in the new book
              this.newBook.coverImage = response.filePath;

              // Add the book to the list
              this.refreshBooks();

              // Reset the form
              this.newBook = { id: 0, title: '', author: '', genre: '', rating: 0, price: 0, coverImage: '' };
              this.selectedFile = null;
            } else {
              console.error('Error uploading file:', response);
            }
          }, error => {
            console.error('Error sending request:', error);
          });
      } else {
        // Add the book without an image
        this.bookService.addBook(this.newBook).subscribe(() => {
          this.refreshBooks();
        });
        this.newBook = { id: 0, title: '', author: '', genre: '', rating: 0, price: 0, coverImage: '' };
      }
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