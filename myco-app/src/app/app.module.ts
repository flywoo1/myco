import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { AppComponent } from './app.component';
import { ReadPersonsComponent } from './persons/read-persons/read-persons.component';
import { HttpModule } from '@angular/http';
import { CreatePersonComponent } from './persons/create-person/create-person.component';
import { ReadOnePersonComponent } from './persons/read-one-person/read-one-person.component';
import { UpdatePersonComponent } from './persons/update-person/update-person.component';
import { DeletePersonComponent } from './persons/delete-person/delete-person.component';


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
