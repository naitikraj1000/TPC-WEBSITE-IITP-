#include <bits/stdc++.h>
using namespace std;

int main()
{
    int t = 68;
    int idx = 0;

    map<int, int> age;
    map<int, float> marks_class_10;
    map<int, float> marks_class_11;
    map<int, float> marks_class_12;
    map<int, float> marks_semester_1;
    map<int, float> marks_semester_2;
    map<int, float> marks_semester_3;
    map<int, float> marks_semester_4;
    map<int, float> marks_semester_5;
    map<int, float> marks_semester_6;
    map<int, float> marks_semester_7;
    map<int, float> marks_semester_8;
    map<int, float> overall_cpi;
    map<int, string> area_of_interest;
    map<int, int> package;
    int placed_or_not = 1;
    area_of_interest[0] = "Investment Banking";
    area_of_interest[1] = "Software Engineering";
    area_of_interest[2] = "Management";
    area_of_interest[3] = "Finance";
    area_of_interest[4] = "Trading";
    area_of_interest[5] = "Consultancy";
    area_of_interest[6] = "Data Scienctist";
    area_of_interest[7] = "Artificial Intelligence";
    area_of_interest[8] = "Digital Marketing";
    area_of_interest[9] = "Product Management";
    area_of_interest[10] = "Human Resources";
    area_of_interest[11] = "Cybersecurity";
    area_of_interest[12] = "Sales";
    area_of_interest[13] = "Entrepreneurship";
    area_of_interest[14] = "Supply Chain Management";
    area_of_interest[15] = "Operations";

    map<int, string> roll_no;
    map<int, string> bb;
    map<string, string> branch{
        {"CB", "Chemical Engineering"},
        {"CE", "Civil Engineering"},
        {"CH", "Chemical Engineering"},
        {"CS", "Computer Science"},
        {"EC", "Electronics and Communication Engineering"},
        {"EE", "Electrical Engineering"},
        {"ME", "Mechanical Engineering"},
        {"MC", "Mathematics and Computing"},
        {"PH", "Engineering Physics"},
        {"BT", "Biotechnology Engineering"},
        {"AI", "Artificial Intelligence Engineering"}};
    map<int, string> batch_year;

    while (t--)
    {
        idx++;
        string s;
        cin >> s;
        roll_no[idx] = s;
        string batch_years = "20";
        batch_years = batch_years + s[0] + s[1];
        int year = stoi(batch_years);
        year += 4;
        batch_years = to_string(year);
        // cout << batch_year << endl;
        batch_year[idx + 1] = batch_years;
        string temp = "";
        temp = temp + s[4] + s[5];
        bb[idx] = temp;
        // Set up a random number generator
        std::random_device rd;
        std::mt19937 gen(rd());
        std::uniform_int_distribution<> dis(21, 24);

        // Generate 68 random values and add them to the vector
        for (int i = 0; i < 68; i++)
        {
            int random_value = dis(gen);
            age[i + 1] = random_value;
        }

        srand(time(nullptr)); // Seed the random number generator with the current time

        // Generate 68 random float values between 75 and 95
        for (int i = 0; i < 68; i++)
        {
            marks_class_10[i + 1] = 75 + static_cast<float>(rand()) / (static_cast<float>(RAND_MAX / (20)));
        }

        for (int i = 0; i < 68; i++)
        {
            marks_class_11[i + 1] = 75 + static_cast<float>(rand()) / (static_cast<float>(RAND_MAX / (20)));
        }

        for (int i = 0; i < 68; i++)
        {
            marks_class_12[i + 1] = 75 + static_cast<float>(rand()) / (static_cast<float>(RAND_MAX / (20)));
        }

        std::srand(std::time(nullptr)); // seed the random number generator with current time
        for (int i = 0; i < 68; i++)
        {
            float value = 6 + static_cast<float>(std::rand()) / (static_cast<float>(RAND_MAX / (9 - 6)));
            marks_semester_1[i + 1] = value;
        }

        std::srand(std::time(nullptr)); // seed the random number generator with current time
        for (int i = 0; i < 68; i++)
        {
            float value = 6 + static_cast<float>(std::rand()) / (static_cast<float>(RAND_MAX / (9 - 6)));
            marks_semester_2[i + 1] = value;
        }
        std::srand(std::time(nullptr)); // seed the random number generator with current time
        for (int i = 0; i < 68; i++)
        {
            float value = 6 + static_cast<float>(std::rand()) / (static_cast<float>(RAND_MAX / (9 - 6)));
            marks_semester_3[i + 1] = value;
        }
        std::srand(std::time(nullptr)); // seed the random number generator with current time
        for (int i = 0; i < 68; i++)
        {
            float value = 6 + static_cast<float>(std::rand()) / (static_cast<float>(RAND_MAX / (9 - 6)));
            marks_semester_4[i + 1] = value;
        }

        std::srand(std::time(nullptr)); // seed the random number generator with current time
        for (int i = 0; i < 68; i++)
        {
            float value = 6 + static_cast<float>(std::rand()) / (static_cast<float>(RAND_MAX / (9 - 6)));
            marks_semester_5[i + 1] = value;
        }
        std::srand(std::time(nullptr)); // seed the random number generator with current time
        for (int i = 0; i < 68; i++)
        {
            float value = 6 + static_cast<float>(std::rand()) / (static_cast<float>(RAND_MAX / (9 - 6)));
            marks_semester_6[i + 1] = value;
        }
        std::srand(std::time(nullptr)); // seed the random number generator with current time
        for (int i = 0; i < 68; i++)
        {
            float value = 6 + static_cast<float>(std::rand()) / (static_cast<float>(RAND_MAX / (9 - 6)));
            marks_semester_7[i + 1] = value;
        }
        std::srand(std::time(nullptr)); // seed the random number generator with current time
        for (int i = 0; i < 68; i++)
        {
            float value = 6 + static_cast<float>(std::rand()) / (static_cast<float>(RAND_MAX / (9 - 6)));
            marks_semester_8[i + 1] = value;
        }

        for (int i = 0; i < 68; i++)
        {
            overall_cpi[i + 1] = (marks_semester_1[i + 1] + marks_semester_2[i + 1] + marks_semester_3[i + 1] + marks_semester_4[i + 1] + marks_semester_5[i + 1] + marks_semester_6[i + 1] + marks_semester_7[i + 1] + marks_semester_8[i + 1]) / 8;
        }

        // Generate 68 random float values between 75 and 95
        for (int i = 0; i < 68; i++)
        {
            package[i + 1] = 12 + static_cast<int>(rand()) / (static_cast<float>(RAND_MAX / (68)));
        }
    }

    for (int idx = 0; idx < 68; idx++)
    {
// cout <<fixed<< "INSERT INTO students_info VALUES ('" << roll_no[idx + 1] << "', '" << branch[bb[idx + 1]] << "', " << age[idx] << ", " << marks_class_10[idx] << ", " << marks_class_11[idx] << ", " << marks_class_12[idx] << ", " << marks_semester_1[idx] << ", " << marks_semester_2[idx] << ", " << marks_semester_3[idx] << ", " << marks_semester_4[idx] << ", " << marks_semester_5[idx] << ", " << marks_semester_6[idx] << ", " << marks_semester_7[idx] << ", " << marks_semester_8[idx] << ", " << overall_cpi[idx + 1] << ", '" << area_of_interest[(idx + 1) % 16] << "', " << batch_year[idx + 1] << ", " << placed_or_not << ", " << package[idx + 1] << ");" << endl;
#include <iomanip> // for std::fixed and std::setprecision

        // ...

        cout << "INSERT INTO students_info VALUES ('" << roll_no[idx+1] << "', '" << branch[bb[idx + 1]] << "', "
             << age[idx] << ", " << fixed << setprecision(2) << marks_class_10[idx+1] << ", "
             << fixed << setprecision(2) << marks_class_11[idx] << ", "
             << fixed << setprecision(2) << marks_class_12[idx] << ", "
             << fixed << setprecision(2) << marks_semester_1[idx] << ", "
             << fixed << setprecision(2) << marks_semester_2[idx] << ", "
             << fixed << setprecision(2) << marks_semester_3[idx] << ", "
             << fixed << setprecision(2) << marks_semester_4[idx] << ", "
             << fixed << setprecision(2) << marks_semester_5[idx] << ", "
             << fixed << setprecision(2) << marks_semester_6[idx] << ", "
             << fixed << setprecision(2) << marks_semester_7[idx] << ", "
             << fixed << setprecision(2) << marks_semester_8[idx] << ", "
             << fixed << setprecision(2) << overall_cpi[idx+1] << ", '"
             << area_of_interest[(idx+1)%15] << "', " << batch_year[idx+1] << ", " << placed_or_not << ", "
             << fixed << setprecision(2) << package[idx + 1] << ");" << endl;
    }
}
