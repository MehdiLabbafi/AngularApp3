import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { BookService } from '../../services/book.service';
import { Book } from '../../models/book.model';

@Component({
  standalone: true,
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css'], // Add the CSS file
  imports: [CommonModule, FormsModule]
})
export class SearchComponent {
  books: Book[] = [];
  searchQuery: string = '';
  selectedGenre: string = 'All';
  sortByRating: boolean = false;

  constructor(private bookService: BookService) {
    this.bookService.getBooks().subscribe((data) => {
      this.books = data;
      this.updateBooksList();
    });
  }

  updateBooksList() {
    // Optional: Update any filters or logic if needed
  }

  searchBooks(): Book[] {
    let filteredBooks = this.books.filter(book =>
      (book.title.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
      book.author.toLowerCase().includes(this.searchQuery.toLowerCase()))
    );

    if (this.selectedGenre !== 'All') {
      filteredBooks = filteredBooks.filter(book => book.genre === this.selectedGenre);
    }

    if (this.sortByRating) {
      filteredBooks = filteredBooks.sort((a, b) => b.rating - a.rating);
    }

    return filteredBooks;
  }

  getGenres(): string[] {
    const genres = this.books.map(book => book.genre);
    return ['All', ...new Set(genres)];
  }
}