import { Routes } from '@angular/router';
import { StudentListComponent } from './pages/student-list/student-list.component';
import { MatchmakingComponent } from './pages/matchmaking/matchmaking.component';

export const routes: Routes = [
  { path: '', redirectTo: 'students', pathMatch: 'full' },
  { path: 'students', component: StudentListComponent },
  { path: 'students/:id/matches', component: MatchmakingComponent }
];
