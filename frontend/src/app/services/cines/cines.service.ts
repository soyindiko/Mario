import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class CinesService {
  private apiUrl = 'http://localhost:8888/api/cines';

  constructor(private http: HttpClient) {}

  getCines(): Observable<any[]> {
    return this.http.get<any>(this.apiUrl).pipe(
      map(response => response.result.data)
    );
  }
}
