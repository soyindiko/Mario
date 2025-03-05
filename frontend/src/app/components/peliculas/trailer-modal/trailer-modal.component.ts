import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';

@Component({
  selector: 'app-trailer-modal',
  standalone: false,
  templateUrl: './trailer-modal.component.html',
  styleUrls: ['./trailer-modal.component.css']
})
export class TrailerModalComponent {
  constructor(
    public dialogRef: MatDialogRef<TrailerModalComponent>,
    @Inject(MAT_DIALOG_DATA) public data: { videoUrl: string }
  ) {}

  isExternalVideo(url: string): boolean {
    return url.includes('youtube') || url.includes('vimeo.com');
  }

  cerrar() {
    this.dialogRef.close();
  }
}