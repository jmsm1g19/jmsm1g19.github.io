import React from 'react';

import { BaseComponent } from '../BaseComponent/BaseComponent';
import Server from '../../db/Server';
import SearchBar from '../SearchBar/SearchBar';
import SearchResults from '../SearchResults/SearchResults';
import Team from '../Team/Team';
import './Adder.css';

class Adder extends BaseComponent {
  constructor(props) {
    super(props);
    this.state = {
      searchResults: [
      ],
      teamName: 'My Team',
      teamUsers: []
    }
    this._bind('updateTeamName', 'addUser', 'removeUser', 'saveTeam', 'search');
  }

  updateTeamName(name) {
    this.setState({
      teamName: name
    });
  }

  addUser(user) {
    if (!this.state.teamUsers.find(teamUser => teamUser.username === user.username)) {
      this.setState(prevState => ({
        teamUsers: [...prevState.teamUsers, user]
      }));
    }
  }

  removeUser(user) {
    this.setState({
      teamUsers: this.state.teamUsers.filter(teamUser => teamUser.username !== user.username)
    });
  }

  saveTeam() {
    const userBorisIds = this.state.teamUsers.map(teamUser => teamUser.borisId);
    Server.saveTeam(this.state.teamName, userBorisIds);
    this.setState({
      searchResults: []
    });
    this.updateTeamName('My Team');
    console.info(userBorisIds);
  }

  search(term) {
    Server.search(term)
      .then(searchResults => this.setState({
        searchResults: searchResults
      }));
  }
  
  render(){
    return (
      <div>
        <h1><span className="highlight">V</span>irus <span className="highlight">V</span>anquisher</h1>
        <div className="Adder">
          <SearchBar onSearch={this.search} />
          <div className="Adder-team">
            <SearchResults searchResults={this.state.searchResults} onAdd={this.addUser} />
            <Team
              name={this.state.teamName}
              users={this.state.teamUsers}
              onRemove={this.removeUser}
              onNameChange={this.updateTeamName}
              onSave={this.saveTeam} />
          </div>
        </div>
      </div>
    );
  }
}

export default Adder;
