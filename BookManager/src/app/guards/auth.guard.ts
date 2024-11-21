import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';

@Injectable({
    providedIn: 'root',
  })
  export class AuthGuard implements CanActivate {
    constructor(private router: Router) {}
  
    canActivate(): boolean {
      const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
      console.log('AuthGuard - Is logged in:', isLoggedIn);
      if (isLoggedIn) {
        return true; // Access to the page is granted
      } else {
        this.router.navigate(['/']); // User is redirected to the login page
        return false; // Access is denied
      }
    }
  }
