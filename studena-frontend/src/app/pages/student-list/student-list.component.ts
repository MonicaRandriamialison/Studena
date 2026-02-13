import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { StudentService, Student } from '../../services/student.service';

@Component({
  selector: 'app-student-list',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './student-list.component.html',
  styleUrl: './student-list.component.css'
})
export class StudentListComponent implements OnInit {
  students: Student[] = [];
  filtered: Student[] = [];
  search = '';
  levelFilter = '';
  loading = false;
  error = '';

  constructor(
    private studentService: StudentService,
    private router: Router,
    private cdr: ChangeDetectorRef
  ) {}

  ngOnInit(): void {
    this.loading = true;
    this.error = '';

    this.studentService.getStudents().subscribe({
      next: (res) => {
        console.log('STUDENTS', res);
        this.students = res || [];
        this.filtered = [...this.students];
        this.loading = false;

        // FORCER LA MISE À JOUR DE L’UI
        this.cdr.detectChanges();
      },
      error: () => {
        this.error = 'Impossible de charger les élèves.';
        this.loading = false;
        this.cdr.detectChanges();
      }
    });
  }

  applyFilter(): void {
    const term = this.search.toLowerCase().trim();

    this.filtered = this.students.filter(s => {
      const name = (s.full_name || '').toLowerCase();
      const level = s.level || '';
      const matchesName = !term || name.includes(term);
      const matchesLevel = this.levelFilter ? level === this.levelFilter : true;
      return matchesName && matchesLevel;
    });

    // On force aussi le rafraîchissement après filtrage
    this.cdr.detectChanges();
  }

  goToMatches(student: Student): void {
    if (!student || !student.id) {
      return;
    }
    this.router.navigate(['/students', student.id, 'matches']);
  }
}
