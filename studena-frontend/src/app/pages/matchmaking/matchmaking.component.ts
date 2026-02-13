import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { MatchmakingService, MatchResult } from '../../services/matchmaking.service';
import { StudentService, Student } from '../../services/student.service';

@Component({
  selector: 'app-matchmaking',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './matchmaking.component.html',
  styleUrl: './matchmaking.component.css'
})
export class MatchmakingComponent implements OnInit {
  selectedStudentId: number | null = null;
  currentStudent: Student | null = null;

  matches: MatchResult[] = [];
  loading = false;
  error = '';

  constructor(
    private matchmakingService: MatchmakingService,
    private studentService: StudentService,
    private route: ActivatedRoute,
    private cdr: ChangeDetectorRef
  ) {}

  ngOnInit(): void {
    // équivalent d’un useEffect qui réagit aux changements de l’ID dans l’URL
    this.route.paramMap.subscribe(params => {
      const id = Number(params.get('id'));
      if (!id) {
        this.error = 'Aucun élève sélectionné.';
        this.cdr.detectChanges();
        return;
      }

      this.selectedStudentId = id;
      this.loading = true;
      this.error = '';
      this.matches = [];
      this.currentStudent = null;
      this.cdr.detectChanges();

      this.studentService.getStudents().subscribe({
        next: (res) => {
          this.currentStudent = res.find(s => s.id === this.selectedStudentId) ?? null;
          this.cdr.detectChanges();
          this.loadMatches();
        },
        error: () => {
          this.error = 'Impossible de charger les informations de l’élève.';
          this.loading = false;
          this.cdr.detectChanges();
        }
      });
    });
  }

  private loadMatches(): void {
    if (!this.selectedStudentId) {
      this.error = 'Aucun élève sélectionné.';
      this.loading = false;
      this.cdr.detectChanges();
      return;
    }

    this.matchmakingService.getMatchesForStudent(this.selectedStudentId).subscribe({
      next: (res) => {
        console.log('MATCHES', res);
        this.matches = res || [];
        this.loading = false;
        this.cdr.detectChanges();
      },
      error: (err) => {
        console.error(err);
        this.error = 'Erreur lors du chargement des tuteurs.';
        this.loading = false;
        this.cdr.detectChanges();
      }
    });
  }

  bestMatch(): MatchResult | null {
    return this.matches && this.matches.length ? this.matches[0] : null;
  }

  subjectNames(m: MatchResult): string {
    if (!m || !m.tutor || !m.tutor.subjects) {
      return '';
    }
    return m.tutor.subjects.map((s: any) => s.name).join(', ');
  }

  levelNames(m: MatchResult): string {
    if (!m || !m.tutor || !m.tutor.levels) {
      return '';
    }
    return m.tutor.levels.map((l: any) => l.name).join(', ');
  }
}
