import { Injectable } from '@angular/core';
import { Book } from '../models/book.model';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BookService {
  private apiUrl = 'http://localhost/BookManagerAPI/books.php';

  constructor(private http: HttpClient) {}

  getBooks(): Observable<Book[]> {
    return this.http.get<Book[]>(this.apiUrl);
  }

  addBook(book: Book): Observable<any> {
    return this.http.post<any>(this.apiUrl, book);
  }

  updateBook(updatedBook: Book): Observable<any> {
    return this.http.put<any>(this.apiUrl, updatedBook);
  }

  deleteBook(bookId: number): Observable<any> {
    return this.http.delete<any>(`${this.apiUrl}?id=${bookId}`);
  }
}
