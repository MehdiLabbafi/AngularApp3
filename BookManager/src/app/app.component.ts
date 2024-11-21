import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { HttpClientModule } from '@angular/common/http'; // اضافه کردن این خط
import { BookListComponent } from './components/book-list/book-list.component';
import { SearchComponent } from './components/search/search.component';

@Component({
  standalone: true,
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  imports: [RouterModule, HttpClientModule, BookListComponent, SearchComponent] // اضافه کردن HttpClientModule
})
export class AppComponent {
  title = 'BookManager';
}