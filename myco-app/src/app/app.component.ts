import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})

export class AppComponent {
  // properties for child components
  title = 'Read Persons';
  person_id;

  // properties used to identify what views to show
  show_read_persons_html = true;
  show_create_person_html = false;
  show_read_one_person_html = false;
  show_update_person_html = false;
  show_delete_person_html = false;

  // show the 'create person form'
  showCreatePerson($event) {

    // set title
    this.title = $event.title;

    // hide all html then show only one html
    this.hideAll_Html();
    this.show_create_person_html = true;
  }

  // show persons list
  showReadPersons($event) {
    // set title
    this.title = $event.title;

    // hide all html then show only one html
    this.hideAll_Html();
    this.show_read_persons_html = true;
  }

  // show details of a person
  showReadOnePerson($event) {

    // set title and person ID
    this.title = $event.title;
    this.person_id = $event.person_id;

    // hide all html then show only one html
    this.hideAll_Html();
    this.show_read_one_person_html = true;
  }

  // show the 'update person form'
  showUpdatePerson($event) {

     // set title and person ID
     this.title = $event.title;
     this.person_id = $event.person_id;

     // hide all html then show only one html
     this.hideAll_Html();
     this.show_update_person_html = true;
  }

  // show 'are you sure?' prompt to confirm deletion of a record
  showDeletePerson($event) {

     // set title and person ID
     this.title = $event.title;
     this.person_id = $event.person_id;

     // hide all html then show only one html
     this.hideAll_Html();
     this.show_delete_person_html = true;
  }

  // hide all html views
  hideAll_Html() {
    this.show_read_persons_html = false;
    this.show_read_one_person_html = false;
    this.show_create_person_html = false;
    this.show_update_person_html = false;
    this.show_delete_person_html = false;
  }
}
