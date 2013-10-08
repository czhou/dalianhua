//
//  ViewController.h
//  dalianhua
//
//  Created by Jack on 7/10/13.
//  Copyright (c) 2013 Salmonapps.com. All rights reserved.
//

#import <UIKit/UIKit.h>

@class Question;

@interface ViewController : UIViewController {
    IBOutlet UITextView *textView;
    IBOutlet UIButton *speakerButton;
    IBOutlet UIButton *skipButton;
}

@property (nonatomic, strong) Question *current;

- (void)render;
- (IBAction)tapPlay:(id)sender;
- (void)tapAnswer:(id)sender;
- (IBAction)tapSkip:(id)sender;

@end
