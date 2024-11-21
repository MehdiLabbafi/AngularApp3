import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { BookListComponent } from './components/book-list/book-list.component';
import { SearchComponent } from './components/search/search.component';

const routes: Routes = [
  { path: 'book-list', component: BookListComponent },
  { path: 'search', component: SearchComponent },
  { path: '**', redirectTo: 'book-list' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {}