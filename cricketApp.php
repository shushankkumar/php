<!-- #include <iostream>
#include <vector>
#include <algorithm>
using namespace std;

// Interface for Cricket Game Activities
class CricketActivities {
public:
    virtual void enterDetails() = 0;
    virtual void displayPlayerAverage(int player_code) = 0;
    virtual void displayAllPlayersAverage() = 0;
    virtual void displaySortedPlayers() = 0;
};

// CricketPlayer class implementing the interface
class CricketPlayer : public CricketActivities {
private:
    struct Player {
        int player_code;
        string name;
        int runs;
        int innings_played;
        int no_of_times_out;

        double calculateAverage() const {
            return no_of_times_out == 0 ? runs : (double)runs / no_of_times_out;
        }
    };

    vector<Player> players;

public:
    void enterDetails() override {
        Player player;
        cout << "Enter player code: ";
        cin >> player.player_code;
        cout << "Enter player name: ";
        cin.ignore();
        getline(cin, player.name);
        cout << "Enter total runs scored: ";
        cin >> player.runs;
        cout << "Enter number of innings played: ";
        cin >> player.innings_played;
        cout << "Enter number of times out: ";
        cin >> player.no_of_times_out;
        players.push_back(player);
        cout << "Player details added successfully!\n";
    }

    void displayPlayerAverage(int player_code) override {
        for (const auto &player : players) {
            if (player.player_code == player_code) {
                cout << "Player Name: " << player.name << "\n";
                cout << "Average Runs: " << player.calculateAverage() << "\n";
                return;
            }
        }
        cout << "Player with code " << player_code << " not found!\n";
    }

    void displayAllPlayersAverage() override {
        double total_runs = 0, total_outs = 0;
        for (const auto &player : players) {
            total_runs += player.runs;
            total_outs += player.no_of_times_out;
        }
        double average = total_outs == 0 ? total_runs : total_runs / total_outs;
        cout << "Average Runs of All Players: " << average << "\n";
    }

    void displaySortedPlayers() override {
        sort(players.begin(), players.end(), [](const Player &a, const Player &b) {
            return a.runs > b.runs;
        });

        cout << "Players sorted by runs:\n";
        for (const auto &player : players) {
            cout << "Player Code: " << player.player_code << ", Name: " << player.name
                 << ", Runs: " << player.runs << ", Average: " << player.calculateAverage() << "\n";
        }
    }
};

// Main Function
int main() {
    CricketPlayer cricketTeam;
    int choice, player_code;

    do {
        cout << "\nCricket Player Management Menu:\n";
        cout << "1. Enter details of players\n";
        cout << "2. Display average runs of a single player\n";
        cout << "3. Display average runs of all players\n";
        cout << "4. Display the list of players in sorted order as per runs\n";
        cout << "5. Exit\n";
        cout << "Enter your choice: ";
        cin >> choice;

        switch (choice) {
        case 1:
            cricketTeam.enterDetails();
            break;
        case 2:
            cout << "Enter player code: ";
            cin >> player_code;
            cricketTeam.displayPlayerAverage(player_code);
            break;
        case 3:
            cricketTeam.displayAllPlayersAverage();
            break;
        case 4:
            cricketTeam.displaySortedPlayers();
            break;
        case 5:
            cout << "Exiting the program...\n";
            break;
        default:
            cout << "Invalid choice! Try again.\n";
        }
    } while (choice != 5);

    return 0;
} -->


<?php
// Interface for Cricket Game Activities
interface CricketGameActivities {
    public function enterDetails($playerCode, $name, $runs, $inningsPlayed, $noOfTimesOut);
    public function calculateAverage();
}

// Class to represent a Cricket Player
class CricketPlayer implements CricketGameActivities {
    private $playerCode;
    private $name;
    private $runs;
    private $inningsPlayed;
    private $noOfTimesOut;
    private $average;

    public function enterDetails($playerCode, $name, $runs, $inningsPlayed, $noOfTimesOut) {
        $this->playerCode = $playerCode;
        $this->name = $name;
        $this->runs = $runs;
        $this->inningsPlayed = $inningsPlayed;
        $this->noOfTimesOut = $noOfTimesOut;
        $this->calculateAverage();
    }

    public function calculateAverage() {
        $this->average = ($this->noOfTimesOut > 0) ? $this->runs / $this->noOfTimesOut : $this->runs;
    }

    public function getDetails() {
        return [
            "playerCode" => $this->playerCode,
            "name" => $this->name,
            "runs" => $this->runs,
            "average" => $this->average
        ];
    }

    public function getRuns() {
        return $this->runs;
    }
}

// Manage multiple players and operations
class CricketManager {
    private $players = [];

    public function addPlayer($player) {
        $this->players[] = $player;
    }

    public function calculateAverageOfAllPlayers() {
        $totalRuns = 0;
        $totalOuts = 0;

        foreach ($this->players as $player) {
            $details = $player->getDetails();
            $totalRuns += $details['runs'];
            $totalOuts += ($details['average'] > 0) ? $details['runs'] / $details['average'] : 0;
        }

        return ($totalOuts > 0) ? $totalRuns / $totalOuts : 0;
    }

    public function displaySortedPlayersByRuns() {
        usort($this->players, function ($a, $b) {
            return $b->getRuns() <=> $a->getRuns();
        });

        foreach ($this->players as $player) {
            $details = $player->getDetails();
            echo "Player Code: {$details['playerCode']}, Name: {$details['name']}, Runs: {$details['runs']}, Average: {$details['average']}<br>";
        }
    }

    public function displayPlayerAverage($playerCode) {
        foreach ($this->players as $player) {
            $details = $player->getDetails();
            if ($details['playerCode'] === $playerCode) {
                echo "Player {$details['name']}'s Average: {$details['average']}<br>";
                return;
            }
        }
        echo "Player with Code {$playerCode} not found!<br>";
    }
}

// Menu-driven program
$manager = new CricketManager();

do {
    echo "\nMenu:\n";
    echo "1. Enter Player Details\n";
    echo "2. Display Average Runs of a Single Player\n";
    echo "3. Display Average Runs of All Players\n";
    echo "4. Display Players Sorted by Runs\n";
    echo "5. Exit\n";
    echo "Enter your choice: ";
    $choice = intval(fgets(STDIN));

    switch ($choice) {
        case 1:
            echo "Enter Player Code: ";
            $playerCode = trim(fgets(STDIN));
            echo "Enter Player Name: ";
            $name = trim(fgets(STDIN));
            echo "Enter Runs Scored: ";
            $runs = intval(fgets(STDIN));
            echo "Enter Innings Played: ";
            $inningsPlayed = intval(fgets(STDIN));
            echo "Enter Number of Times Out: ";
            $noOfTimesOut = intval(fgets(STDIN));

            $player = new CricketPlayer();
            $player->enterDetails($playerCode, $name, $runs, $inningsPlayed, $noOfTimesOut);
            $manager->addPlayer($player);

            echo "Player added successfully!\n";
            break;

        case 2:
            echo "Enter Player Code to Search: ";
            $playerCode = trim(fgets(STDIN));
            $manager->displayPlayerAverage($playerCode);
            break;

        case 3:
            $avgAllPlayers = $manager->calculateAverageOfAllPlayers();
            echo "Average Runs of All Players: {$avgAllPlayers}\n";
            break;

        case 4:
            echo "Players Sorted by Runs:\n";
            $manager->displaySortedPlayersByRuns();
            break;

        case 5:
            echo "Exiting...\n";
            break;

        default:
            echo "Invalid choice! Try again.\n";
    }
} while ($choice !== 5);
?>