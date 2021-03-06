import React from 'react';

import { BaseComponent } from '../BaseComponent/BaseComponent';
import UserList from '../UserList/UserList';
import './SearchResults.css';

class SearchResults extends BaseComponent {
  render() {
    return (
      <div className="SearchResults">
        <h2>Results</h2>
        <UserList users={this.props.searchResults} onAdd={this.props.onAdd} />
      </div>
    );
  }
}

export default SearchResults;
