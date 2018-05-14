import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { AppComponent } from './app.component';
import { ReadPersonsComponent } from './read-persons/read-persons.component';
import { HttpModule } from '@angular/http';
import { CreatePersonComponent } from './create-person/create-person.component';
import { ReadOnePersonComponent } from './read-one-person/read-one-person.component';
import { UpdatePersonComponent } from './update-person/update-person.component';
import { DeletePersonComponent } from './delete-person/delete-person.component';


@NgModule({
  declarations: [
    AppComponent,
    ReadPersonsComponent,
    CreatePersonComponent,
    ReadOnePersonComponent,
    UpdatePersonComponent,
    DeletePersonComponent
  ],
  imports: [
    BrowserModule,
    HttpModule,
    FormsModule,
    ReactiveFormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
