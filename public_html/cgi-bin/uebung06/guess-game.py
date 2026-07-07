#!/usr/bin/python3
import random

to_guess = random.randint(0, 99)
tries = 0

print("Willkommen beim Zahlenratespiel!")
print("Ich habe mir eine Zahl zwischen 0 und 99 ausgedacht.")

while True:
    try:
        userInputString = input("Bitte Zahl zwischen 0 und 99 eingeben: ")
        userInputInt = int(userInputString)
        
        if not (0 <= userInputInt <= 99):
            print("Fehler: Bitte eine Zahl zwischen 0 und 99 eingeben")
            continue
        
        tries += 1
            
        if userInputInt < to_guess:
            print("Die zu erratende Zahl ist groesser!")
        elif userInputInt > to_guess:
            print("Die zu erratende Zahl ist kleiner!")
        elif userInputInt == to_guess:
            print(f"Glueckwunsch, Zahl erraten. Anzahl Versuche: {tries}")
            break
        
    except ValueError:
        print("Fehler: Das war keine gültige Zahl. Bitte versuche es erneut.")
    print("-" * 20)
 