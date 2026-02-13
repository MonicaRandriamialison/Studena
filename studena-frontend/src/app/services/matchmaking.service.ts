import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface MatchResult {
  tutor: any;
  score: number;
  match_type: string;
  availability_overlap: string;
}

@Injectable({
  providedIn: 'root'
})
export class MatchmakingService {

  private apiUrl = 'http://127.0.0.1:8000/api';

  constructor(private http: HttpClient) {}

  getMatchesForStudent(studentId: number): Observable<MatchResult[]> {
    return this.http.get<MatchResult[]>(`${this.apiUrl}/students/${studentId}/matches`);
  }
}
