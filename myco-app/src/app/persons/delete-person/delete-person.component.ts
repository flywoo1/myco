import { Component, Input, Output, EventEmitter } from '@angular/core';
import { PersonService } from '../../person.service';
import { Observable } from 'rxjs';
import { Person } from '../../person';

@Component({
  selector: 'app-delete-person',
  templateUrl: './delete-person.component.html',
  styleUrls: ['./delete-person.component.css'],
  providers: [PersonService]
})

export class DeletePersonComponent {

  /*
      @Output will tell the parent component (AppComponent)
      that an event has happened (via .emit(), see readPersons() method below)
  */
  @Output() show_read_persons_event = new EventEmitter();

  // @Input enable getting the person_id from parent component (AppComponent)
  @Input() person_id;
  @Input() coproperty_id;
  @Input() role;

  // initialize person service
  constructor(private personService: PersonService) { }

  // user clicks 'yes' button
  deletePerson() {

    // delete data from database
    this.personService.deletePerson(this.person_id)
      .subscribe(
      person => {

        // show an alert to tell the user if person was created or not
        console.log(person);

        // go back to list of persons
        this.readPersons();
      },
      error => console.log(error)
      );
  }

  // user clicks the 'read persons' button
  readPersons() {
    this.show_read_persons_event.emit({ title: 'Read ' + this.role, role: this.role, coproperty_id: this.coproperty_id });
  }

}
