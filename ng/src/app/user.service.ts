import {Injectable} from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  user: User | null = null;

  constructor() {
  }


  get(): User | null {
    if (!this.user) {
      let u = localStorage.getItem('user');
      if (u != null)
        this.user = JSON.parse(u);
    }
    return this.user;
  }

  getToken(): string {
    let user = this.get();
    if (user == null) {
      return '';
    } else {
      return user.token;
    }
  }

  remove() {
    this.user = null;
    localStorage.removeItem('user');
  }

  set(
    user: User,
  ) {
    this.user = user;
    localStorage.setItem('user', JSON.stringify(user));
  }
}

export interface User {
  token: string,
  user_id: string,
  username: string,
  group: string,
  email: string,
  last_login: string,
  login_hash: string,
  profile_fields: string,
  created_at: string,
  updated_at: string,
}
