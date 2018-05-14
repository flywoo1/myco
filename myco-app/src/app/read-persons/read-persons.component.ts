import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { PersonService } from '../person.service';
import { Observable } from 'rxjs';
import { Person } from '../person';

@Component({
    selector: 'app-read-persons',
    templateUrl: './read-persons.component.html',
    styleUrls: ['./read-persons.component.css'],
    providers: [PersonService]
})

export class ReadPersonsComponent implements OnInit {

    /*
      * Needed to notify the 'consumer of this component', which is the 'AppComponent',
        that an 'event' happened in this component.
    */
    @Output() show_create_person_event = new EventEmitter();
    @Output() show_read_one_person_event = new EventEmitter();
    @Output() show_update_person_event = new EventEmitter();
    @Output() show_delete_person_event = new EventEmitter();

    // store list of persons
    persons: Person[];

    // initialize personService to retrieve list persons in the ngOnInit()
    constructor(private personService: PersonService) {}

    // methods that we will use later
    createPerson() {
        // tell the parent component (AppComponent)
        this.show_create_person_event.emit({
            title: 'Create Person'
        });
    }

    // when user clicks the 'read' button
    readOnePerson(id) {
        console.log('rp comp readOnePerson');
        // tell the parent component (AppComponent)
        this.show_read_one_person_event.emit({
            person_id: id,
            title: 'Read One Person'
        });
    }
    // when user clicks the 'update' button
    updatePerson(id) {
        // tell the parent component (AppComponent)
        this.show_update_person_event.emit({
            person_id: id,
            title: 'Update Person'
        });
    }
    // when user clicks the 'delete' button
    deletePerson(id) {
        // tell the parent component (AppComponent)
        this.show_delete_person_event.emit({
            person_id: id,
            title: 'Delete Person'
        });
    }

    // Read persons from API.
    ngOnInit() {
        this.personService.readPersons()
            .subscribe(persons =>
                this.persons = persons['records']
            );
    }
}
