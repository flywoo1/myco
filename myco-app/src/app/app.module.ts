import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';


import { AppComponent } from './app.component';
import { ReadPersonsComponent } from './persons/read-persons/read-persons.component';
import { HttpModule } from '@angular/http';
import { CreatePersonComponent } from './persons/create-person/create-person.component';
import { ReadOnePersonComponent } from './persons/read-one-person/read-one-person.component';
import { UpdatePersonComponent } from './persons/update-person/update-person.component';
import { DeletePersonComponent } from './persons/delete-person/delete-person.component';

import { routing } from './app.routing';

// used to create fake backend
import { FakeBackendProvider } from './_helpers';

import { AlertComponent } from './_directives';
import { AuthGuard } from './_guards';
import { JwtInterceptor } from './_helpers';
import { AlertService, AuthenticationService, UserService } from './_services';

import { HomeComponent } from './home';
import { LoginComponent } from './login';
import { RegisterComponent } from './register';
import { PersonComponent } from './persons';

@NgModule({
  declarations: [
    AppComponent,
    ReadPersonsComponent,
    CreatePersonComponent,
    ReadOnePersonComponent,
    UpdatePersonComponent,
    DeletePersonComponent,
    PersonComponent,
    AlertComponent,
    RegisterComponent,
    HomeComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    HttpModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    routing
  ],
  providers: [
    AuthGuard,
    AlertService,
    AuthenticationService,
    UserService,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: JwtInterceptor,
      multi: true
    },
    // provider used to create fake backend
    FakeBackendProvider
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
