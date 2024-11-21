import { Routes } from '@angular/router';
import { BookListComponent } from './components/book-list/book-list.component';
import { SearchComponent } from './components/search/search.component';

export const routes: Routes = [
  { path: 'book-list', component: BookListComponent },
  { path: 'search', component: SearchComponent },
  { path: '**', redirectTo: 'book-list' } // مسیر پیش‌فرض
];
