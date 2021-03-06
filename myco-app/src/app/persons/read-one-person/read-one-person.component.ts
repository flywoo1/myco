import { Component, OnInit, Input, Output, OnChanges, EventEmitter } from '@angular/core';
import { PersonService } from '../../person.service';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Person } from '../../person';

@Component({
  selector: 'app-read-one-person',
  templateUrl: './read-one-person.component.html',
  styleUrls: ['./read-one-person.component.css'],
  providers: [PersonService]
})

export class ReadOnePersonComponent implements OnChanges {

  /*
      @Output will tell the parent component (AppComponent)
      that an event has happened (via .emit(), see readPersons() method below)
  */
  @Output() show_read_persons_event = new EventEmitter();

  // @Input means it will accept value from parent component (AppComponent)
  @Input() person_id;
  @Input() coproperty_id;
  @Input() role;

  person: Person;

  // initialize person service
  constructor(private personService: PersonService) { }

  // user clicks the 'read persons' button
  readPersons() {
    this.show_read_persons_event.emit({ title: 'Read ' + this.role, role: this.role, coproperty_id: this.coproperty_id });
  }



  // read one person
  readPerson() {
    this.personService.readOnePerson(this.person_id)
    // .filter(person => person.owners)
    .subscribe(person => this.person = person);
  }

  hasThisRoleInThisCopro = (role, Roles) => {
    let index = Roles.findIndex(item => item.idCoproperty === this.coproperty_id);
    if (this.role !== role) {
        index = -1;
    }
    return index;
  }


  // call the record when 'person_id' was changed
  ngOnChanges() {
    this.readPerson();
  }

}
